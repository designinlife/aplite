<?php
namespace APLite\Interfaces;

use APLite\Router\RouteResponse;

/**
 * 路由解析器接口。
 *
 * @package       APLite\Interfaces
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
interface IRouteParser {
    /**
     * 解析路由。
     *
     * @return RouteResponse
     */
    function parse();
}