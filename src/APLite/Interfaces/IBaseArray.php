<?php
namespace APLite\Interfaces;

/**
 * IBaseArray 对象转 PHP 数组接口。
 *
 * @package       APLite\Interfaces
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
interface IBaseArray {
    /**
     * 对象转换为数组。
     *
     * @param array $options
     * @return array
     */
    function toArray(array $options = []);

    /**
     * 对象转换为 JSON 字符串。
     *
     * @param array $options
     * @return string
     */
    function toJSONString(array $options = []);
}