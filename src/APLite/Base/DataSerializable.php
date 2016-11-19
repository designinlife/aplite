<?php
namespace APLite\Base;

use APLite\Interfaces\IBaseArray;

/**
 * 数据序列化抽象类。
 *
 * @package       APLite\Base
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
abstract class DataSerializable implements IBaseArray {
    /**
     * 对象转换为数组。
     *
     * @param array $options
     * @return array
     */
    function toArray(array $options = []) {
        $d     = [];
        $ref   = new \ReflectionClass($this);
        $props = $ref->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PROTECTED);

        foreach ($props as $prop) {
            $prop->setAccessible(true);

            $d[$prop->getName()] = $prop->getValue($this);
        }

        return $d;
    }

    /**
     * 对象转换为 JSON 字符串。
     *
     * @param array $options
     * @return string
     */
    function toJSONString(array $options = []) {
        $d = $this->toArray($options);

        return json_encode($d, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * The __toString method allows a class to decide how it will react when it is converted to a string.
     *
     * @return string
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.tostring
     */
    function __toString() {
        return \msgpack_serialize($this);
    }
}