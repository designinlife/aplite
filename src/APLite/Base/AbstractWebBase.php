<?php
namespace APLite\Base;

use APLite\Bootstrap\WebBootstrap;

/**
 * Class AbstractWebBase
 *
 * @package       APLite\Base
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class AbstractWebBase {
    /**
     * WebBootstrap 实例。
     *
     * @var WebBootstrap
     */
    protected $bootstrap = NULL;

    /**
     * 构造函数。
     *
     * @param WebBootstrap $bootstrap 指定 WebBootstrap 上下文实例。
     */
    function __construct(WebBootstrap $bootstrap) {
        $this->bootstrap = $bootstrap;
    }

    /**
     * 析构函数。
     */
    function __destruct() {
        unset($this->bootstrap);
    }
}