<?php
namespace APLite\Base;

use APLite\Bootstrap\ProcessBootstrap;

/**
 * Class AbstractProcessBase
 *
 * @package       APLite\Base
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class AbstractProcessBase {
    /**
     * ProcessBootstrap 实例。
     *
     * @var ProcessBootstrap
     */
    protected $bootstrap = NULL;

    /**
     * 构造函数。
     *
     * @param ProcessBootstrap $bootstrap 指定 ProcessBootstrap 上下文实例。
     */
    function __construct(ProcessBootstrap $bootstrap) {
        $this->bootstrap = $bootstrap;
    }

    /**
     * 析构函数。
     */
    function __destruct() {
        unset($this->bootstrap);
    }
}