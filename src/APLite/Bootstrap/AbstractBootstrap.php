<?php
namespace APLite\Bootstrap;

use APLite\Cache\MemcacheClient;
use APLite\Cache\RedisClient;
use APLite\DB\DbParameter;
use APLite\DB\DbPdo;
use APLite\Exceptions\ArgumentException;
use APLite\Exceptions\ConfigurationException;
use APLite\Interfaces\ICache;
use APLite\Interfaces\IController;
use APLite\Interfaces\IProcess;
use APLite\Interfaces\IRouteParser;
use APLite\Interfaces\IRouteValidator;
use APLite\Queue\SQ;
use APLite\Router\RouteResponse;
use Pheanstalk\Pheanstalk;

/**
 * 抽象 Bootstrap 启动器。
 *
 * @package       APLite\Bootstrap
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
abstract class AbstractBootstrap {
    /**
     * 框架版本号。
     *
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * 框架名称。
     *
     * @var string
     */
    protected $name = 'APLite';

    /**
     * 系统时区。
     *
     * @var string
     */
    protected $timezone = 'Asia/Shanghai';

    /**
     * 错误报告级别。
     *
     * @var int
     */
    protected $error_reporting = E_ALL & ~E_NOTICE;

    /**
     * 控制器命名空间。
     *
     * @var string
     */
    protected $controller_ns = NULL;

    /**
     * 是否命令行运行模式？
     *
     * @var bool
     */
    protected $cli_running = false;

    /**
     * 检测到异常时是否退出应用程序？
     *
     * @var bool
     */
    protected $exception_exit = true;

    /**
     * 路由结果对象。
     *
     * @var RouteResponse
     */
    protected $route_response = NULL;

    /**
     * 路由解析器对象。
     *
     * @var IRouteParser
     */
    protected $route_parser = NULL;

    /**
     * 路由验证器列表。
     *
     * @var \APLite\Interfaces\IRouteValidator[]
     */
    protected $route_validators = [];

    /**
     * log4php 日志对象。
     *
     * @var \Logger
     */
    protected $logger = NULL;

    /**
     * log4php 配置文件或数组。
     *
     * @var array|string
     */
    protected $logger_configuration = NULL;

    /**
     * IDb 实例列表。
     *
     * @var \APLite\Interfaces\IDb[]
     */
    protected $dbs = [];

    /**
     * Beanstalkd 客户端对象实例。
     *
     * @var Pheanstalk
     */
    public $sqs = NULL;

    /**
     * 缓存客户端对象实例。
     *
     * @var ICache|\Redis
     */
    public $cache = NULL;

    /**
     * 全局配置参数列表。
     *
     * @var array
     */
    public $cfgs = NULL;

    /**
     * 命令行参数列表。
     *
     * @var array
     */
    public $argv = NULL;

    /**
     * 执行请求调度。
     *
     * @param array $cfgs 全局配置参数列表。
     * @param array $argv 命令行参数列表。
     * @throws ConfigurationException
     */
    final function dispatch(array &$cfgs, array &$argv = NULL) {
        if (0 == strcmp('cli', PHP_SAPI)) {
            $this->cli_running = true;
            $this->argv        = &$argv;
        }

        $this->cfgs = &$cfgs;

        date_default_timezone_set($this->timezone);

        set_error_handler([$this, 'defErrorHandler'], $this->error_reporting);
        set_exception_handler([$this, 'defExceptionHandler']);

        register_shutdown_function([$this, 'defShutdownHandler']);

        // 实例化全局日志管理对象 ...
        \APLite\Logger\Logger::configure($this->logger_configuration);

        $this->logger = \APLite\Logger\Logger::getLogger('APLite');

        if (!isset($cfgs['dbs']['default']))
            throw new ConfigurationException('未检测到缺省数据库配置。');

        // 实例化 IDb 对象列表 ...
        if (is_array($cfgs['dbs'])) {
            foreach ($cfgs['dbs'] as $k => $v) {
                $dbo = new DbPdo($this);
                $dbo->setDbParameter(new DbParameter($v['host'], $v['port'], $v['user'], $v['pass'], $v['db'], $v['charset'], isset($v['sock']) ? $v['sock'] : NULL, isset($v['init']) ? $v['init'] : NULL, isset($v['timeout']) ? $v['timeout'] : 0, isset($v['auto_reconnect']) ? $v['auto_reconnect'] : false));

                $this->dbs[$k] = $dbo;
            }
        }

        // 实例化队列服务 ...
        if (isset($cfgs['sqs']['host'], $cfgs['sqs']['port'])) {
            $this->sqs = new \Pheanstalk\Pheanstalk($cfgs['sqs']['host'], $cfgs['sqs']['port']);

            SQ::initialize($this);
        }

        // 实例化缓存服务 ...
        if (isset($cfgs['cache']['enable']) && true === $cfgs['cache']['enable']) {
            if ($cfgs['cache']['type'] == 'redis') {
                $this->cache = new RedisClient();
                $this->cache->connect($cfgs['cache']['host'], $cfgs['cache']['port']);

                if (isset($cfgs['cache']['pass']))
                    $this->cache->auth($cfgs['cache']['pass']);
            } elseif ($cfgs['cache']['type'] == 'memcached') {
                $this->cache = new MemcacheClient($cfgs['cache']['host'], $cfgs['cache']['port'], '');
            }
        }

        $this->initialize();
        $this->initializeComplete();
        $this->parse();
        $this->validate();
        $this->execute();
    }

    /**
     * 初始化事件。
     */
    abstract function initialize();

    /**
     * 初始化完成事件。
     */
    abstract function initializeComplete();

    /**
     * 解析请求参数。
     */
    final function parse() {
        if ($this->route_parser instanceof IRouteParser) {
            $this->route_response = $this->route_parser->parse();
        } else {
            throw new \RuntimeException('未指定 IRouteParser 路由解析器对象。');
        }
    }

    /**
     * 验证请求合法性。
     */
    final function validate() {
        if (!empty($this->route_validators)) {
            foreach ($this->route_validators as $validator) {
                $validator->validate($this->route_response);
            }
        }
    }

    /**
     * 执行控制器行为。
     */
    protected function execute() {
        $cls_n = $this->controller_ns . '\\' . $this->route_response->getController();
        $cls_m = $this->route_response->getMethod();

        $cls_o = new $cls_n($this);

        if ($cls_o instanceof IController) {
            $cls_o->initialize();

            if ($this->isCliRunning() && $cls_o instanceof IProcess) {
                $r = $cls_o->parse($this->argv);
                $cls_o->run();
            } else {
                $cls_o->$cls_m();
            }

            $cls_o->dispose();
        } else {
            throw new \RuntimeException('控制器对象必须实现 IController 接口。');
        }
    }

    /**
     * 缺省错误处理函数。
     *
     * @param int    $errno
     * @param string $errstr
     * @param string $errfile
     * @param int    $errline
     * @throws \ErrorException
     */
    function defErrorHandler($errno, $errstr, $errfile, $errline) {
        throw new \ErrorException($errstr, $errno, 0, $errfile, $errline);
    }

    /**
     * 缺省异常处理函数。
     *
     * @param \Exception $ex
     */
    function defExceptionHandler(\Exception $ex) {
        if ($this->logger) {
            $this->logger->error($ex->getMessage(), $ex);
        }

        echo $ex->getMessage(), PHP_EOL;
        echo $ex->getTraceAsString(), PHP_EOL;

        if ($this->exception_exit)
            exit(2);
    }

    /**
     * shutdown 事件回调。
     */
    function defShutdownHandler() {
        if (is_array($this->dbs)) {
            foreach ($this->dbs as $k => $dbo) {
                $dbo->close();

                $this->dbs[$k] = NULL;
            }
        }

        if ($this->sqs && $this->sqs->getConnection()->hasSocket())
            $this->sqs->getConnection()->disconnect();

        if ($this->cache) {
            $this->cache->close();
        }

        $this->sqs   = NULL;
        $this->cache = NULL;
    }

    /**
     * 获取框架版本号。
     *
     * @return string
     */
    function getVersion() {
        return $this->version;
    }

    /**
     * 获取框架名称。
     *
     * @return string
     */
    function getName() {
        return $this->name;
    }

    /**
     * 指示是否命令行运行模式？
     *
     * @return boolean
     */
    function isCliRunning() {
        return $this->cli_running;
    }

    /**
     * 获取系统时区。
     *
     * @return string
     */
    function getTimezone() {
        return $this->timezone;
    }

    /**
     * 设置系统时区。
     *
     * @param string $timezone
     * @return AbstractBootstrap
     */
    function setTimezone($timezone) {
        $this->timezone = $timezone;

        return $this;
    }

    /**
     * 获取错误报告级别。
     *
     * @return int
     */
    function getErrorReporting() {
        return $this->error_reporting;
    }

    /**
     * 设置错误报告级别。
     *
     * @param int $error_reporting
     * @return AbstractBootstrap
     */
    function setErrorReporting($error_reporting) {
        $this->error_reporting = $error_reporting;

        return $this;
    }

    /**
     * 获取控制器命令空间。
     *
     * @return string
     */
    function getControllerNs() {
        return $this->controller_ns;
    }

    /**
     * 设置控制器命令空间。
     *
     * @param string $controller_ns
     * @return AbstractBootstrap
     */
    function setControllerNs($controller_ns) {
        $this->controller_ns = $controller_ns;

        return $this;
    }

    /**
     * 捕获到异常时是否退出？
     *
     * @return bool
     */
    function isExceptionExit() {
        return $this->exception_exit;
    }

    /**
     * 捕获到异常时是否退出？
     *
     * @param bool $exception_exit
     * @return AbstractBootstrap
     */
    function setExceptionExit($exception_exit) {
        $this->exception_exit = $exception_exit;

        return $this;
    }

    /**
     * 设置路由解析器对象实例。
     *
     * @param IRouteParser $route_parser
     * @return AbstractBootstrap
     */
    function setRouteParser($route_parser) {
        $this->route_parser = $route_parser;

        return $this;
    }

    /**
     * 设置路由验证器实例列表。
     *
     * @param \APLite\Interfaces\IRouteValidator[] ...$validators
     * @return AbstractBootstrap
     */
    function addRouteValidator(IRouteValidator ... $validators) {
        $this->route_validators = $validators;

        return $this;
    }

    /**
     * 获取全局日志管理对象。
     *
     * @return \Logger
     */
    function getLogger() {
        return $this->logger;
    }

    /**
     * 设置日志配置文件路径。
     *
     * @param array|string $configuration
     * @return AbstractBootstrap
     */
    function setLoggerConfiguration($configuration) {
        $this->logger_configuration = $configuration;

        return $this;
    }

    /**
     * 获取 IDb 对象实例。
     *
     * @param string $db_index 指定 DBs 配置索引。
     * @return \APLite\Interfaces\IDb
     * @throws ArgumentException
     */
    function getDb($db_index = 'default') {
        if (!isset($this->dbs[$db_index]))
            throw new ArgumentException('未检测到活动的 IDb 实例对象。(db=' . $db_index . ')');

        return $this->dbs[$db_index];
    }
}