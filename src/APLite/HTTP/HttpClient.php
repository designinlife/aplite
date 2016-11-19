<?php
namespace APLite\HTTP;

use APLite\Base\AbstractBase;
use APLite\Exceptions\HttpClientException;
use APLite\Exceptions\HttpNonResponseException;
use APLite\Exceptions\HttpStatusException;

/**
 * 基于 Curl 的 HTTP 客户端类。
 *
 * @package       APLite\HTTP
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class HttpClient extends AbstractBase {
    /**
     * 发送请求。
     *
     * @param HttpRequest $httpRequest 指定 HttpGet/HttpPost 参数对象。
     * @return HttpResponse
     * @throws HttpClientException
     * @throws HttpNonResponseException
     * @throws HttpStatusException
     */
    function send(HttpRequest $httpRequest) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $httpRequest->getUrl());
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);

        if ($httpRequest->getMethod() == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $httpRequest->getParams());
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpRequest->getRequestHeaders());

        $r = curl_exec($ch);

        $errno     = curl_errno($ch);
        $error     = curl_error($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (false === $r || $errno != 0)
            throw new HttpClientException('HTTP 请求失败。(' . $error . ')', 4001);

        if (!($http_code >= 200 && $http_code < 300))
            throw new HttpStatusException('请求响应状态异常。', 4002, $http_code);

        // if (empty($r))
        //     throw new HttpNonResponseException('返回内容为空。', 4003);

        $obr = new HttpResponse($r, [], $http_code);

        return $obr;
    }
}