<?php
namespace APLite\HTTP;

use APLite\AP;
use APLite\Base\DataSerializable;

/**
 * HTTP Request 类。
 *
 * @package       APLite\HTTP
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
abstract class HttpRequest extends DataSerializable {
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
     * 数据类型。
     *
     * @var int
     */
    protected $data_type = AP::ENC_NONE;

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
     * 获取响应内容编码类型。
     *
     * @return int
     */
    function getDataType() {
        return $this->data_type;
    }

    /**
     * 设置响应内容编码类型。
     *
     * @param int $data_type 编码类型。(注: 请务必使用 AP::ENC_* 常量定义.)
     * @return HttpRequest
     */
    function setDataType($data_type) {
        $this->data_type = $data_type;

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
}