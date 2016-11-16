<?php
namespace APLite\Interfaces;

/**
 * Interface IDisposable
 *
 * @package       APLite\Interfaces
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
interface IDisposable {
    /**
     * 释放资源。
     */
    function dispose();
}