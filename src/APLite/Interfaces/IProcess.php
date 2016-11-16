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
     * 获取命令行参数选项列表。
     *
     * @return \GetOptionKit\OptionCollection|null
     */
    function getOptions();

    /**
     * 解析参数选项。
     *
     * @param array $argv
     */
    function parse(array $argv = NULL);

    /**
     * 执行命令。
     */
    function run();
}