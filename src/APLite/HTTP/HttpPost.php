<?php
namespace APLite\HTTP;

/**
 * HTTP POST 请求对象。
 *
 * @package       APLite\HTTP
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class HttpPost extends HttpRequest {
    /**
     * 构造函数。
     *
     * @param string $url             请求地址。
     * @param array  $params          指定参数对象。
     * @param array  $headers         指定请求头信息。
     * @param int    $connect_timeout 连接超时。(毫秒 | 默认值: 3000)
     * @param int    $timeout         请求读写超时。(毫秒 | 默认值: 5000)
     */
    function __construct($url, array $params = NULL, array $headers = [], $connect_timeout = 3000, $timeout = 5000) {
        $this->method = 'POST';

        parent::__construct($url, $params, $headers, $connect_timeout, $timeout);
    }
}