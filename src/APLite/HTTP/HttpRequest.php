<?php
namespace APLite\HTTP;

use APLite\Interfaces\IBaseArray;

/**
 * HTTP Request 类。
 *
 * @package       APLite\HTTP
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
abstract class HttpRequest implements IBaseArray {
    /**
     * 连接超时。(毫秒)
     *
     * @var int
     */
    protected $connect_timeout = 3000;

    /**
     * 请求超时。(毫秒)
     *
     * @var int
     */
    protected $timeout = 5000;

    /**
     * 请求方式。
     *
     * @var string
     */
    protected $method = 'GET';

    /**
     * 请求地址。
     *
     * @var string
     */
    protected $url = '';

    /**
     * 请求参数。
     *
     * @var array|null
     */
    protected $params = NULL;

    /**
     * 请求头信息。
     *
     * @var array
     */
    protected $request_headers = [];

    /**
     * 构造函数。
     *
     * @param string $url             请求地址。
     * @param int    $connect_timeout 连接超时。(毫秒 | 默认值: 3000)
     * @param int    $timeout         请求读写超时。(毫秒 | 默认值: 5000)
     */
    function __construct($url, $connect_timeout = 3000, $timeout = 5000) {
        $this->url             = $url;
        $this->connect_timeout = $connect_timeout;
        $this->timeout         = $timeout;
    }

    /**
     * 获取连接超时。(毫秒)
     *
     * @return int
     */
    function getConnectTimeout() {
        return $this->connect_timeout;
    }

    /**
     * 设置连接超时。(毫秒)
     *
     * @param int $connect_timeout
     * @return HttpRequest
     */
    function setConnectTimeout($connect_timeout) {
        $this->connect_timeout = $connect_timeout;

        return $this;
    }

    /**
     * 获取请求读/写超时。(毫秒)
     *
     * @return int
     */
    function getTimeout() {
        return $this->timeout;
    }

    /**
     * 设置请求读/写超时。(毫秒)
     *
     * @param int $timeout
     * @return HttpRequest
     */
    function setTimeout($timeout) {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * 获取请求参数。
     *
     * @return array|null
     */
    function getParams() {
        return $this->params;
    }

    /**
     * 设置请求参数。
     *
     * @param array|null $params
     * @return HttpRequest
     */
    function setParams(array $params = NULL) {
        $this->params = $params;

        return $this;
    }

    /**
     * 获取请求头信息。
     *
     * @return array
     */
    function getRequestHeaders() {
        return $this->request_headers;
    }

    /**
     * 设置请求头信息。
     *
     * @param array $request_headers
     * @return HttpRequest
     */
    function setRequestHeaders($request_headers) {
        $this->request_headers = $request_headers;

        return $this;
    }

    /**
     * 获取请求方式。
     *
     * @return string
     */
    function getMethod() {
        return $this->method;
    }

    /**
     * 获取请求地址。
     *
     * @return string
     */
    function getUrl() {
        return $this->url;
    }

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