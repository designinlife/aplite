<?php
namespace APLite\Exceptions;

/**
 * Class SQLException
 *
 * @package       APLite\Exceptions
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class SQLException extends DbException {
    private $sql = '';

    private $params = NULL;

    /**
     * 构造函数。
     *
     * @param string     $message 异常消息。
     * @param string     $sql     执行的 SQL 语句。
     * @param array|null $params  查询参数列表。
     * @param int        $code    异常代码。
     * @param \Exception $previous
     */
    function __construct($message, $sql, $params = NULL, $code = 0, \Exception $previous = NULL) {
        $this->sql    = $sql;
        $this->params = $params;

        parent::__construct($message, $code, $previous);
    }

    /**
     * String representation of the exception
     *
     * @link  http://php.net/manual/en/exception.tostring.php
     * @return string the string representation of the exception.
     * @since 5.1.0
     */
    function __toString() {
        return sprintf('%s (Params: %s)', $this->sql, json_encode($this->params, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }

    /**
     * 获取 SQL 查询语句。
     *
     * @return string
     */
    function getSql() {
        return $this->sql;
    }

    /**
     * 获取 SQL 查询参数列表。
     *
     * @return array
     */
    function getParams() {
        return $this->params;
    }
}