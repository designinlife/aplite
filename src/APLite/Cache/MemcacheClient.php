<?php
namespace APLite\Cache;

use APLite\Interfaces\ICache;
use APLite\Logger\Logger;

/**
 * Memcached 客户端。
 *
 * @package       APLite\Cache
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class MemcacheClient implements ICache {
    /**
     * 主机地址。
     *
     * @var string
     */
    private $host = '127.0.0.1';

    /**
     * 端口。
     *
     * @var int
     */
    private $port = 11211;

    /**
     * 登录验证密码。
     *
     * @var string
     */
    private $password = '';

    /**
     * 是否已连接？
     *
     * @var bool
     */
    private $connected = false;

    /**
     * Memcache 客户端实例。
     *
     * @var \Memcache
     */
    private $instance = NULL;

    /**
     * 日志对象。
     *
     * @var Logger
     */
    private $logger = NULL;

    /**
     * 构造函数。
     *
     * @param string $host
     * @param int    $port
     * @param string $passwd
     * @param Logger $logger
     */
    function __construct($host, $port, $passwd, Logger $logger = NULL) {
        $this->host     = $host;
        $this->port     = $port;
        $this->password = $passwd;
        $this->logger   = $logger;
    }

    /**
     * 析构函数。
     */
    function __destruct() {
        unset($this->logger);
    }

    /**
     * 连接缓存服务器。
     */
    function connect() {
        if (!$this->connected) {
            $this->instance = new \Memcache();
            $this->instance->addServer($this->host, $this->port);

            $this->connected = true;
        }
    }

    /**
     * 断开连接。
     */
    function close() {
        if ($this->instance) {
            $this->instance->close();
        }

        $this->connected = false;
    }

    /**
     * 登录验证。
     *
     * @return bool
     */
    function auth() {
        return true;
    }

    /**
     * 切换缓存数据库。
     *
     * @param int $db_index
     * @return bool
     */
    function select($db_index = 0) {
        return true;
    }

    /**
     * 设置服务器选项参数。
     *
     * @param string     $key
     * @param int|string $value
     */
    function setOption($key, $value) {
    }

    /**
     * 获取服务器选项参数。
     *
     * @param string $key
     * @return int|string
     */
    function getOption($key) {
        return false;
    }

    /**
     * 获取服务器信息列表。
     *
     * @return array
     */
    function info() {
        $this->connect();

        return $this->instance->getStats();
    }

    /**
     * 清空缓存数据库。
     *
     * @return bool
     */
    function flushDb() {
        $this->connect();

        return $this->instance->flush();
    }

    /**
     * 清空缓存数据库。
     *
     * @return bool
     */
    function flushAll() {
        $this->connect();

        return $this->instance->flush();
    }

    /**
     * 设置缓存数据过期时间。
     *
     * @param string $key 指定缓存键名。
     * @param int    $ttl 指定过期时间。(单位: 秒)
     * @return bool
     */
    function expire($key, $ttl) {
        return true;
    }

    /**
     * 设置缓存数据过期时间。
     *
     * @param string $key       指定缓存键名。
     * @param int    $expire_ts 指定过期的时间戳。
     * @return bool
     */
    function expireAt($key, $expire_ts) {
        return true;
    }

    /**
     * 设置缓存数据。
     *
     * @param string $key   指定缓存键名。
     * @param mixed  $value 指定数据值对象。
     * @param int    $ttl   指定过期时间。(单位: 秒 | 默认值: 0,永不过期)
     * @return bool
     */
    function set($key, $value, $ttl = 0) {
        $this->connect();

        return $this->instance->set($key, $value, 0, $ttl);
    }

    /**
     * 获取缓存数据。
     *
     * @param string $key 指定缓存键名。
     * @return mixed
     */
    function get($key) {
        $this->connect();

        return $this->instance->get($key);
    }

    /**
     * 删除缓存。
     *
     * @param string $key 指定缓存键名。
     * @return bool
     */
    function del($key) {
        $this->connect();

        return $this->instance->delete($key);
    }

    /**
     * 检查缓存键是否存在？
     *
     * @param string $key 指定缓存键名。
     * @return bool
     */
    function exists($key) {
        $this->connect();

        return false !== $this->instance->get($key);
    }

    /**
     * 指示是否 Redis 缓存？
     *
     * @return bool
     */
    function isRedis() {
        return false;
    }

    /**
     * 指示是否 Memcached 缓存？
     *
     * @return bool
     */
    function isMemcached() {
        return true;
    }
}