<?php
namespace APLite\Exceptions;
use Exception;

/**
 * Class HttpStatusException
 *
 * @package       APLite\Exceptions
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class HttpStatusException extends HttpClientException {
    /**
     * HTTP 响应状态码。
     *
     * @var int
     */
    private $http_code = 0;

    /**
     * Construct the exception. Note: The message is NOT binary safe.
     *
     * @link  http://php.net/manual/en/exception.construct.php
     * @param string    $message   The Exception message to throw.
     * @param int       $code      The Exception code.
     * @param int       $http_code The http status code.
     * @param Exception $previous  [optional] The previous exception used for the exception chaining. Since 5.3.0
     * @since 5.1.0
     */
    function __construct($message, $code, $http_code, Exception $previous) {
        $this->http_code = $http_code;

        parent::__construct($message, $code, $previous);
    }

    /**
     * 获取 HTTP 状态码。
     *
     * @return int
     */
    function getHttpCode() {
        return $this->http_code;
    }
}