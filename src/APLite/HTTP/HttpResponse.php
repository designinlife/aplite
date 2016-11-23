<?php
namespace APLite\HTTP;

/**
 * HTTP Client 响应结果对象。
 *
 * @package       APLite\HTTP
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class HttpResponse {
    /**
     * HTTP 状态码。
     *
     * @var int
     */
    protected $http_code = 200;

    /**
     * 服务器响应头信息。
     *
     * @var array
     */
    protected $headers = [];

    /**
     * 服务器响应内容。
     *
     * @var mixed
     */
    protected $body = NULL;

    /**
     * 构造函数。
     *
     * @param mixed $body      响应内容。
     * @param array $headers   响应头信息。
     * @param int   $http_code HTTP 状态码。
     */
    function __construct($body, array $headers, $http_code = 200) {
        $this->headers   = $headers;
        $this->body      = $body;
        $this->http_code = $http_code;
    }

    /**
     * 获取 HTTP 响应状态码。
     *
     * @return int
     */
    function getHttpCode() {
        return $this->http_code;
    }

    /**
     * 获取响应头信息。
     *
     * @return array
     */
    function getHeaders() {
        return $this->headers;
    }

    /**
     * 获取响应内容。
     *
     * @return mixed
     */
    function getBody() {
        return $this->body;
    }
}