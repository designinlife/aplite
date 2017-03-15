<?php
namespace APLite\DB;

use APLite\AP;
use APLite\Base\AbstractBase;
use APLite\Exceptions\NotImplementedException;
use APLite\Exceptions\SQLException;
use APLite\Interfaces\IDb;
use APLite\Utility\Util;
use PDO;

/**
 * PDO for MySQL 管理对象。
 *
 * @package       APLite\DB
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class DbPdo extends AbstractBase implements IDb {
    /**
     * PDO 对象。
     *
     * @var PDO
     */
    private $dbo = NULL;

    /**
     * 连接参数对象。
     *
     * @var DbParameter
     */
    private $dbParameter = NULL;

    /**
     * 当前事务级别。
     *
     * @var int
     */
    private $transLevel = 0;

    /**
     * 是否自动提交事务？
     *
     * @var bool
     */
    private $auto_commit = TRUE;

    /**
     * 指示是否已连接？
     *
     * @var bool
     */
    private $connected = false;

    /**
     * 是否断开后自动重新连接？
     *
     * @var bool
     */
    private $auto_reconnect = false;

    /**
     * 已重连的次数。
     *
     * @var int
     */
    private $reconnect_times = 0;

    /**
     * 客户端连接 ID。
     *
     * @var int
     */
    private $connection_id = 0;

    /**
     * 连接数据库。
     */
    function connect() {
        if (!$this->connected) {
            $opts = array(
                PDO::ATTR_ERRMODE                  => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_STRINGIFY_FETCHES        => false,
                PDO::ATTR_AUTOCOMMIT               => $this->auto_commit,
                PDO::ATTR_CASE                     => PDO::CASE_NATURAL,
                PDO::ATTR_DEFAULT_FETCH_MODE       => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND       => 'SET NAMES `' . $this->dbParameter->getCharset() . '`',
                PDO::ATTR_PERSISTENT               => false,
                PDO::ATTR_EMULATE_PREPARES         => false,
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => false,
            );

            if ($this->dbParameter->hasSock()) {
                $dsn = 'mysql:dbname=' . $this->dbParameter->getDb() . ';unix_socket=' . $this->dbParameter->getSock();
            } else {
                $dsn = 'mysql:dbname=' . $this->dbParameter->getDb() . ';host=' . $this->dbParameter->getHost() . ';port=' . $this->dbParameter->getPort();
            }

            try {
                $this->dbo = new PDO($dsn, $this->dbParameter->getUser(), $this->dbParameter->getPassword(), $opts);

                // 设置 MySQL 事务隔离级别 ...
                if ($this->dbParameter->hasInitCommand()) {
                    $this->dbo->exec($this->dbParameter->getInitCommand());
                } else {
                    if ($this->dbParameter->getTimeout() > 0)
                        $this->dbo->exec("SET SESSION wait_timeout = " . $this->dbParameter->getTimeout() . ", interactive_timeout = " . $this->dbParameter->getTimeout() . ";");
                }
                // $this->dbo->exec("SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED; SET SESSION wait_timeout = 7776000, interactive_timeout = 7776000;");

                // 设置当前客户端连接 ID ...
                // $this->connection_id = ( int ) $this->dbo->query("SELECT CONNECTION_ID()")->fetchColumn(0);

                $this->setAutoReconnect($this->dbParameter->isAutoReconnect());
            } catch (\Exception $ex) {
                throw $ex;
            }

            $this->connected = true;
        }
    }

    /**
     * 关闭数据库。
     */
    function close() {
        if ($this->dbo)
            $this->dbo = NULL;

        $this->connected  = FALSE;
        $this->transLevel = 0;
    }

    /**
     * 开启事务。(注: 当事务计数器非零时, 此方法返回 False 值。)
     *
     * @return bool
     */
    function begin() {
        // 调用 begin 方法一般在业务 SQL 执行之前, 因此此处检查数据库是否已连接!
        if (!$this->connected)
            $this->connect();

        if (0 === $this->transLevel) {
            // $this->dbo->exec('START TRANSACTION');
            $this->dbo->beginTransaction();
        }

        $this->transLevel++;

        return TRUE;
    }

    /**
     * 提交事务。
     *
     * @return bool
     */
    function commit() {
        $this->transLevel--;

        if (0 === $this->transLevel) {
            // $this->dbo->exec('COMMIT');
            $this->dbo->commit();
        }

        return TRUE;
    }

    /**
     * 回滚事务。(注: 当事务计数器不等于 1 时, 此方法返回 False 值。)
     *
     * @return bool
     */
    function rollback() {
        $this->transLevel--;

        if (0 === $this->transLevel) {
            // $this->dbo->exec('ROLLBACK');
            $this->dbo->rollBack();
        }

        return TRUE;
    }

    /**
     * 读取一行记录。
     *
     * @param string $sql    指定 SQL 指令。
     * @param array  $params 预编译参数列表。
     * @return array|bool
     */
    function fetch($sql, $params = NULL) {
        $d = $this->execute($sql, $params, AP::SQL_TYPE_FETCH);

        return $d;
    }

    /**
     * 读取全部记录。
     *
     * @param string $sql    指定 SQL 指令。
     * @param array  $params 预编译参数列表。
     * @return array|bool
     */
    function fetchAll($sql, $params = NULL) {
        $d = $this->execute($sql, $params, AP::SQL_TYPE_FETCH_ALL);

        return $d;
    }

    /**
     * 读取单行单列数据。
     *
     * @param string $sql    指定 SQL 指令。
     * @param array  $params 预编译参数列表。
     * @param int    $column 指定读取第一行中的第几列。
     * @return int|string
     */
    function scalar($sql, $params = NULL, $column = 0) {
        $d = $this->execute($sql, $params, AP::SQL_TYPE_SCALAR);

        return $d;
    }

    /**
     * 执行一条或多条 SQL 更新指令并返回影响行数。(例如: DDL/INSERT/UPDATE/DELETE/CREATE/ALTER/DROP ...)
     *
     * @param string|array $sql 指定一条(组) SQL 指令。
     * @return int
     */
    function exec($sql) {
        if (!$this->connected)
            $this->connect();

        $affected = 0;

        if (is_array($sql)) {
            foreach ($sql as $v) {
                if (!empty($v))
                    $affected += $this->_exec($v);
            }
        } else {
            $affected = $this->_exec($sql);
        }

        return $affected;
    }

    /**
     * 执行预编译 SQL 指令。
     *
     * @param string $sql      指定需要执行的 SQL 指令。
     * @param array  $params   指定参数列表。
     * @param int    $sql_type 指定 SQL 类型。(注: 务必使用 AP::SQL_TYPE_* 常量定义)
     * @return mixed
     * @throws SQLException
     */
    function execute($sql, $params = NULL, $sql_type = AP::SQL_TYPE_UPDATE) {
        if (!$this->connected)
            $this->connect();

        $sth = NULL;
        $d   = false;

        try {
            $sth = $this->dbo->prepare($sql);

            if (!empty($params)) {
                foreach ($params as $k => $v) {
                    if (is_array($v))
                        $sth->bindValue(1 + $k, $v[0], $v[1]);
                    else
                        $sth->bindValue(1 + $k, $v);
                }
            }

            $sth->execute();

            switch ($sql_type) {
                case AP::SQL_TYPE_INSERT:
                    $d = $this->dbo->lastInsertId();
                    break;
                case AP::SQL_TYPE_UPDATE:
                case AP::SQL_TYPE_DELETE:
                    $d = $sth->rowCount();
                    break;
                case AP::SQL_TYPE_FETCH:
                    $d = $sth->fetch();
                    break;
                case AP::SQL_TYPE_FETCH_ALL:
                    $d = $sth->fetchAll();
                    break;
                case AP::SQL_TYPE_SCALAR:
                    $d = $sth->fetchColumn();
                    break;
                default:
                    throw new NotImplementedException('检测到无效的 SQL 类型。');
            }
        } catch (\Exception $ex) {
            // 检测是否支持自动重连机制？
            // ---------------------------------------------------
            if (Util::contains($ex->getMessage(), ['server has gone away', 'no connection to the server', 'Lost connection', 'is dead or not enabled', 'Error while sending']) && $this->auto_reconnect) {
                $this->bootstrap->getLogger()->warn('检测到 MySQL 连接断开, 已重新连接并执行上一条未成功的 SQL 查询! (' . $sql . ')');

                $this->reconnect_times++;

                $this->close();

                return $this->execute($sql, $params, $sql_type);
            } else {
                throw new SQLException($ex->getMessage(), $sql, $params, 500, $ex);
            }
        } finally {
            if ($sth)
                $sth->closeCursor();
            $sth = NULL;
        }

        return $d;
    }

    /**
     * 设置 DB 连接参数对象。
     *
     * @param DbParameter $dbParameter
     * @return IDb
     */
    function setDbParameter(DbParameter $dbParameter) {
        $this->dbParameter = $dbParameter;

        return $this;
    }

    /**
     * 设置 DB 自动重新连接开关。
     *
     * @param $auto_reconnect
     * @return IDb
     */
    function setAutoReconnect($auto_reconnect) {
        $this->auto_reconnect = $auto_reconnect;

        return $this;
    }

    /**
     * 获取事务计数器值。
     *
     * @return int
     */
    function getTransactionCount() {
        return $this->transLevel;
    }

    /**
     * 获取自动重连的次数。
     *
     * @return int
     */
    function getReconnectTimes() {
        return $this->reconnect_times;
    }

    /**
     * 内部执行方法。
     *
     * @param string $sql
     * @return int
     * @throws SQLException
     */
    private function _exec($sql) {
        if (!$this->connected)
            $this->connect();

        try {
            $affected = $this->dbo->exec($sql);

            return $affected;
        } catch (\PDOException $ex) {
            // 检测是否支持自动重连机制？
            // ---------------------------------------------------
            if ($this->auto_reconnect) {
                if (Util::contains($ex->getMessage(), ['server has gone away', 'no connection to the server', 'Lost connection', 'is dead or not enabled', 'Error while sending'])) {
                    $this->reconnect_times++;

                    $this->close();

                    $this->bootstrap->getLogger()->warn('检测到 PDO 连接已断开, 已启用自动重连!');

                    return $this->_exec($sql);
                }
            } else {
                throw new SQLException($ex->getMessage(), $sql, NULL, $ex->getCode());
            }
        }

        return false;
    }

    /**
     * 获取当前客户端连接 ID。
     *
     * @return int
     */
    function getConnectionId() {
        return $this->connection_id;
    }

    /**
     * 获取状态信息。
     *
     * @return array
     */
    function getStatusInfos() {
        if (!$this->connected)
            $this->connect();

        $attrs = array(
            "AUTOCOMMIT",
            "ERRMODE",
            "CASE",
            "CLIENT_VERSION",
            "CONNECTION_STATUS",
            "ORACLE_NULLS",
            "PERSISTENT",
            "PREFETCH",
            "SERVER_INFO",
            "SERVER_VERSION",
            "TIMEOUT",
        );

        $d = [];

        foreach ($attrs as $v) {
            try {
                $d[$v] = $this->dbo->getAttribute(constant("PDO::ATTR_$v"));
            } catch (\Exception $ex) {
            }
        }

        $d['CONNECTION_ID'] = ( int ) $this->dbo->query("SELECT CONNECTION_ID()")->fetchColumn(0);

        return $d;
    }

    /**
     * Quotes a string for use in a query.
     *
     * @param string $str
     * @param int    $parameter_type
     * @return string
     */
    function quote($str, $parameter_type = \PDO::PARAM_STR) {
        if (!$this->connected)
            $this->connect();

        return $this->dbo->quote($str, $parameter_type);
    }
}