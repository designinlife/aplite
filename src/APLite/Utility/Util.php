<?php
namespace APLite\Utility;

/**
 * APLite 常用工具类。
 *
 * @package       APLite\Utility
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class Util {
    /**
     * 合并名称空间、类名并返回完全限定名。
     *
     * @param array ...$args
     * @return string
     */
    static function ns(...$args) {
        if (empty($args))
            return '';

        return implode('\\', $args);
    }

    /**
     * 字符串变量替换。(支持可变参数)
     *
     * @param array ...$args
     * @return string
     */
    static function substitute(...$args) {
        $size = sizeof($args);
        $str  = $args[0];

        for ($i = 1; $i < $size; $i++) {
            $str = str_replace('{' . ($i - 1) . '}', $args[$i], $str);
        }

        return $str;
    }

    /**
     * 生成 36 位 UUID 全局唯一代码。
     *
     * @return string
     */
    static function uuid() {
        return \uuid_create();
    }

    /**
     * Determine if a given string contains a given substring.
     *
     * @param  string       $haystack
     * @param  string|array $needles
     * @return bool
     */
    static function contains($haystack, $needles) {
        foreach ((array) $needles as $needle) {
            if ($needle != '' && strpos($haystack, $needle) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * 替换字符串变量。
     *
     * @param string $message 指定消息文本内容。
     * @param array  $vars    指定 HashMap 键值对列表。
     * @param string $prefix  指定变量命名规范前缀字符。(可选 | 默认: % 百分号)
     * @return string
     */
    static function translate($message, $vars, $prefix = '%') {
        $s = array();
        $r = array();

        foreach ($vars as $key => $value) {
            $s[] = $prefix . '{' . $key . '}';
            $r[] = $value;
        }

        return str_replace($s, $r, $message);
    }

    /**
     * 获取字符串真实长度。(注: 中文以 2 个字节计算)
     *
     * @param string $str      指定测试字符串。
     * @param string $encoding 指定字符串编码。(默认值: UTF-8)
     * @return int
     */
    static function length($str, $encoding = 'UTF-8') {
        return (strlen($str) + mb_strlen($str, $encoding)) / 2;
    }

    /**
     * Convert strings with underscores into CamelCase
     *
     * @param string $string          The string to convert
     * @param bool   $first_char_caps camelCase or CamelCase
     * @return string    The converted string
     *
     */
    static function toCamelCase($string, $first_char_caps = false) {
        if ($first_char_caps == true) {
            $string[0] = strtoupper($string[0]);
        } else {
            $string[0] = strtolower($string[0]);
        }
        $func = create_function('$c', 'return strtoupper($c[1]);');

        return preg_replace_callback('/[_-]([a-z])/', $func, $string);
    }

    /**
     * Determine if a given string starts with a given substring.
     *
     * @param  string       $haystack
     * @param  string|array $needles
     * @return bool
     */
    static function startsWith($haystack, $needles) {
        foreach ((array) $needles as $needle) {
            if ($needle != '' && strpos($haystack, $needle) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if a given string ends with a given substring.
     *
     * @param  string       $haystack
     * @param  string|array $needles
     * @return bool
     */
    static function endsWith($haystack, $needles) {
        foreach ((array) $needles as $needle) {
            if ((string) $needle === substr($haystack, -strlen($needle))) {
                return true;
            }
        }

        return false;
    }

    /**
     * 转换秒数到指定的字符串格式。
     *
     * @param int    $seconds 秒数。
     * @param string $format  显示格式。(默认值: 时:分:秒 | 具体参见 DateInterval::format 文档.)
     * @return string
     */
    static function formatSeconds($seconds, $format = '%H:%I:%S') {
        $dtF = new \DateTime("@0");
        $dtT = new \DateTime("@" . $seconds);

        return $dtF->diff($dtT)->format($format);
    }
}