<?php
namespace APLite\Exceptions;

use Exception;

/**
 * Class FileNotFoundException
 *
 * @package       APLite\Exceptions
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class FileNotFoundException extends IOException {
    private $filename = '';

    /**
     * Construct the exception. Note: The message is NOT binary safe.
     *
     * @link  http://php.net/manual/en/exception.construct.php
     * @param string    $message  [optional] The Exception message to throw.
     * @param string    $filename [optional] The filename.
     * @param int       $code     [optional] The Exception code.
     * @param Exception $previous [optional] The previous exception used for the exception chaining. Since 5.3.0
     * @since 5.1.0
     */
    function __construct($message, $filename = NULL, $code = 0, Exception $previous = NULL) {
        $this->filename = $filename;

        parent::__construct($message, $code, $previous);
    }

    /**
     * 获取文件路径。
     *
     * @return null|string
     */
    function getFilename() {
        return $this->filename;
    }
}