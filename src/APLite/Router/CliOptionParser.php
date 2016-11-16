<?php
namespace APLite\Router;

use APLite\Base\AbstractProcessBase;
use APLite\Exceptions\ArgumentException;
use APLite\Interfaces\IRouteParser;

/**
 * 命令行参数解析器。
 *
 * @package       APLite\Router
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class CliOptionParser extends AbstractProcessBase implements IRouteParser {
    /**
     * 解析路由。
     *
     * @return RouteResponse
     * @throws ArgumentException
     */
    function parse() {
        if (empty($this->bootstrap->argv[1]))
            throw new ArgumentException('未指定 Process 控制器。');

        return new RouteResponse($this->bootstrap->argv[1], 'run');
    }
}