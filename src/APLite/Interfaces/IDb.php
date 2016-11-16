<?php
namespace APLite\Interfaces;

use APLite\AP;
use APLite\DB\DbParameter;

/**
 * IDb 数据库管理接口。
 *
 * @package       APLite\Interfaces
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
interface IDb extends IBase {
    /**
     * 连接数据库。
     */
    function connect();

    /**
     * 关闭数据库。
     */
    function close();

    /**
     * 开启事务。(注: 当事务计数器非零时, 此方法返回 False 值。)
     *
     * @return bool
     */
    function begin();

    /**
     * 提交事务。(注: 当事务计数器不等于 1 时, 此方法返回 False 值。)
     *
     * @return bool
     */
    function commit();

    /**
     * 回滚事务。(注: 当事务计数器不等于 1 时, 此方法返回 False 值。)
     *
     * @return bool
     */
    function rollback();

    /**
     * 读取一行记录。
     *
     * @param string $sql    指定 SQL 指令。
     * @param array  $params 预编译参数列表。
     * @return array|bool
     */
    function fetch($sql, $params = NULL);

    /**
     * 读取全部记录。
     *
     * @param string $sql    指定 SQL 指令。
     * @param array  $params 预编译参数列表。
     * @return array|bool
     */
    function fetchAll($sql, $params = NULL);

    /**
     * 读取单行单列数据。
     *
     * @param string $sql    指定 SQL 指令。
     * @param array  $params 预编译参数列表。
     * @param int    $column 指定读取第一行中的第几列。
     * @return int|string
     */
    function scalar($sql, $params = NULL, $column = 0);

    /**
     * 执行一条或多条 SQL 更新指令并返回影响行数。(例如: DDL/INSERT/UPDATE/DELETE/CREATE/ALTER/DROP ...)
     *
     * @param string|array $sql 指定一条(组) SQL 指令。
     * @return int              更新影响的行数。
     */
    function exec($sql);

    /**
     * 执行预编译 SQL 指令。
     *
     * @param string $sql      指定需要执行的 SQL 指令。
     * @param array  $params   指定参数列表。
     * @param int    $sql_type 指定 SQL 类型。(注: 务必使用 AP::SQL_TYPE_* 常量定义)
     * @return mixed
     */
    function execute($sql, $params = NULL, $sql_type = AP::SQL_TYPE_UPDATE);

    /**
     * 设置 DB 连接参数对象。
     *
     * @param DbParameter $dbParameter
     * @return IDb
     */
    function setDbParameter(DbParameter $dbParameter);

    /**
     * 设置 DB 自动重新连接开关。
     *
     * @param $auto_reconnect
     * @return IDb
     */
    function setAutoReconnect($auto_reconnect);

    /**
     * 获取事务计数器值。
     *
     * @return int
     */
    function getTransactionCount();

    /**
     * 获取自动重连的次数。
     *
     * @return int
     */
    function getReconnectTimes();

    /**
     * 获取当前客户端连接 ID。
     *
     * @return int
     */
    function getConnectionId();

    /**
     * 获取状态信息。
     *
     * @return array
     */
    function getStatusInfos();

    /**
     * Quotes a string for use in a query.
     *
     * @param string $str
     * @param int    $parameter_type
     * @return string
     */
    function quote($str, $parameter_type = \PDO::PARAM_STR);
}