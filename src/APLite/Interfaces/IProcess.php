<?php
namespace APLite\Interfaces;

/**
 * 命令行进程接口。
 *
 * @package       APLite\Interfaces
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
interface IProcess extends IController {
    /**
     * 执行命令。
     */
    function run();
}