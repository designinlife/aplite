<?php
namespace APLite\Interfaces;

/**
 * ITemplate 模板管理接口。
 *
 * @package       APLite\Interfaces
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
interface ITemplate {
    /**
     * 模板变量赋值。
     *
     * @param string $key
     * @param mixed  $value
     * @return ITemplate
     */
    function assign($key, $value);

    /**
     * 输出模板内容。
     *
     * @param string $tpl_file 模板文件名称。
     * @return void
     */
    function display($tpl_file);

    /**
     * 模板渲染。
     *
     * @param string $name
     * @param array  $context
     * @return mixed
     */
    function render($name, array $context = []);
}