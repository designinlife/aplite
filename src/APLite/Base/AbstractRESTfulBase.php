<?php
namespace APLite\Base;

use APLite\Bootstrap\RESTfulBootstrap;

/**
 * Class AbstractRESTfulBase
 *
 * @package       APLite\Base
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2017, Lei Lee
 */
abstract class AbstractRESTfulBase {
    /**
     * RESTfulBootstrap 实例。
     *
     * @var RESTfulBootstrap
     */
    protected $bootstrap = NULL;

    /**
     * 构造函数。
     *
     * @param RESTfulBootstrap $bootstrap 指定 RESTfulBootstrap 上下文实例。
     */
    function __construct(RESTfulBootstrap $bootstrap) {
        $this->bootstrap = $bootstrap;
    }

    /**
     * 析构函数。
     */
    function __destruct() {
        unset($this->bootstrap);
    }
}