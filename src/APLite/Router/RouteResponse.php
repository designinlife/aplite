<?php
namespace APLite\Router;

/**
 * IRouteParser 解析结果对象。
 *
 * @package       APLite\Router
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class RouteResponse {
    /**
     * 控制器名称。
     *
     * @var string
     */
    private $controller = '';

    /**
     * 接口方法名称。
     *
     * @var string
     */
    private $method = '';

    /**
     * 参数列表。
     *
     * @var array
     */
    private $arguments = [];

    /**
     * 构造函数。
     *
     * @param string $controller 控制器名称。
     * @param string $method     接口方法名称。
     * @param array  $arguments  参数列表。(可选)
     */
    function __construct($controller, $method, array $arguments = []) {
        $this->controller = $controller;
        $this->method     = $method;
        $this->arguments  = $arguments;
    }

    /**
     * 获取控制器名称。
     *
     * @return string
     */
    function getController() {
        return $this->controller;
    }

    /**
     * 获取接口方法名称。
     *
     * @return string
     */
    function getMethod() {
        return $this->method;
    }

    /**
     * 获取参数列表。
     *
     * @return array
     */
    function getArguments() {
        return $this->arguments;
    }
}