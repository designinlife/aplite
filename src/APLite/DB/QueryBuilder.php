<?php
namespace APLite\DB;

use APLite\Exceptions\ArgumentException;
use APLite\Interfaces\IDb;

/**
 * SQL 多查询构建器。
 *
 * @package       APLite\DB
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2017, Lei Lee
 */
class QueryBuilder {
    /**
     * 数据库管理对象。
     *
     * @var IDb
     */
    private $db = NULL;

    /**
     * 查询列表。
     *
     * @var array
     */
    private $datas = [];

    /**
     * 构造函数。
     *
     * @param IDb $db
     */
    function __construct(IDb $db) {
        $this->db = $db;
    }

    /**
     * 析构函数。
     */
    function __destruct() {
        unset($this->db);
    }

    /**
     * 添加查询。
     *
     * @param string $key      指定数据键名。
     * @param string $sql      指定查询语句。
     * @param array  $params   指定参数参数。
     * @param int    $sql_type 指定查询类型。
     * @return QueryBuilder
     * @throws ArgumentException
     */
    function addQuery($key, $sql, array $params = [], $sql_type = 11) {
        if (!in_array($sql_type, [11, 12, 13]))
            throw new ArgumentException('参数异常。');

        $this->datas[$key] = [$sql, $params, $sql_type];

        return $this;
    }

    /**
     * 执行查询并返回结果集。
     *
     * @return array
     */
    function execute() {
        $dr  = [];
        $ops = [11 => 'fetch', 12 => 'fetchAll', 13 => 'scalar'];

        foreach ($this->datas as $k => $v) {
            $dr[$k] = $this->db->{$ops[$v[2]]}($v[0], $v[1]);
        }

        return $dr;
    }
}