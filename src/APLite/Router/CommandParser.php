<?php
namespace APLite\Router;

use APLite\Base\AbstractWebBase;
use APLite\Bootstrap\WebBootstrap;
use APLite\Exceptions\ArgumentException;
use APLite\Exceptions\FileNotFoundException;
use APLite\Interfaces\IRouteParser;

/**
 * 基于 $cfgs_cmd_map 配置的指令路由解析器对象。
 *
 * @package       APLite\Router
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class CommandParser extends AbstractWebBase implements IRouteParser {
    /**
     * 指令协议配置文件。
     *
     * @var string
     */
    private $command_file = '';

    /**
     * 命令参数名称。
     *
     * @var string
     */
    private $command_key = 'cmd';

    /**
     * 构造函数。
     *
     * @param WebBootstrap $bootstrap    指定 AbstractBootstrap 上下文实例。
     * @param string       $command_file 指定指令配置文件路径。
     * @param string       $command_key  指定命令参数名称。(默认值: cmd)
     */
    function __construct(WebBootstrap $bootstrap, $command_file, $command_key = 'cmd') {
        parent::__construct($bootstrap);

        $this->command_key  = $command_key;
        $this->command_file = $command_file;
    }

    /**
     * 解析路由。
     *
     * @return RouteResponse
     * @throws ArgumentException
     * @throws FileNotFoundException
     */
    function parse() {
        if (!file_exists($this->command_file))
            throw new FileNotFoundException('文件未找到。', $this->command_file);

        require $this->command_file;

        if (isset($_GET[$this->command_key]))
            $cmd = $_GET[$this->command_key];
        else
            $cmd = 1001;

        if (!isset($cfgs_cmd_map[$cmd]))
            throw new ArgumentException('未定义的指令名称。(' . $cmd . ')');

        return new RouteResponse($cfgs_cmd_map[$cmd][0], $cfgs_cmd_map[$cmd][1], $cfgs_cmd_map[$cmd]);
    }
}