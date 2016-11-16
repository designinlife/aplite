<?php
namespace APLite\Interfaces;

use APLite\Router\RouteResponse;

/**
 * IRouteValidator 路由验证器接口。
 *
 * @package       APLite\Interfaces
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
interface IRouteValidator extends IBase {
    /**
     * 验证路由合法性。
     *
     * @param RouteResponse $routeResponse
     * @return int
     */
    function validate(RouteResponse $routeResponse);
}