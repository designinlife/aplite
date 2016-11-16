<?php
namespace APLite\Interfaces;

use APLite\Bootstrap\AbstractBootstrap;

/**
 * IBase 接口。
 *
 * @package       APLite\Interfaces
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
interface IBase {
    /**
     * 构造函数。
     *
     * @param AbstractBootstrap $bootstrap 指定 AbstractBootstrap 上下文实例。
     */
    function __construct(AbstractBootstrap $bootstrap);
}