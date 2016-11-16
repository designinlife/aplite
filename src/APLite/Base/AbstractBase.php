<?php
namespace APLite\Base;

use APLite\Bootstrap\AbstractBootstrap;

/**
 * Class AbstractBase
 *
 * @package       APLite\Base
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
abstract class AbstractBase {
    /**
     * AbstractBootstrap 实例。
     *
     * @var AbstractBootstrap
     */
    protected $bootstrap = NULL;

    /**
     * 构造函数。
     *
     * @param AbstractBootstrap $bootstrap 指定 AbstractBootstrap 上下文实例。
     */
    function __construct(AbstractBootstrap $bootstrap) {
        $this->bootstrap = $bootstrap;
    }

    /**
     * 析构函数。
     */
    function __destruct() {
        unset($this->bootstrap);
    }
}