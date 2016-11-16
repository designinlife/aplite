<?php
namespace APLite\Interfaces;

/**
 * 控制器标准接口。
 *
 * @package       APLite\Interfaces
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
interface IController extends IDisposable {
    /**
     * 控制器初始化事件。
     */
    function initialize();
}