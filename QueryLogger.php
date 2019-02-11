<?php

namespace vendor\penwork;

class QueryLogger
{
    /** @var string $tableName */
    public $tableName;

    /** @var array $queryTypes */
    public $queryExcludeTypes = [];

    /** @var \PDO $pdo */
    public $pdo;

    /** @var self $instance */
    protected static $instance;

    protected function __construct(\PDO $pdo)
    {
        $dbConfig = require ROOT . '/config/db_config.php';
        $this->tableName = $dbConfig['log_query_table_name'];
        $this->queryExcludeTypes = $dbConfig['log_query_exclude_types'];
        $this->pdo = $pdo;
    }

    public static function getLogger(\PDO $pdo): ?self
    {
        if (self::$instance === null) {
            self::$instance = new self($pdo);
        }

        $tableName = self::$instance->tableName;

        if (!$tableName || $tableName === '') {
            return null;
        }

        return self::$instance;
    }

    public function log(string $sql, bool $success): void
    {
        foreach ($this->queryExcludeTypes as $excludeType) {
            if (strpos($sql, $excludeType) === 0) {
                return;
            }
        }

        $safeSql = addslashes($sql);
        $safeSql = str_replace("\n", '', $safeSql);

        $successString = (int)$success;

        $logSql = "INSERT INTO $this->tableName (`sql`, `success`) VALUES ('$safeSql', $successString)";

        $this->pdo->prepare($logSql)->execute();
    }
}