<?php
declare(strict_types=1);

namespace Penwork;

class QueryLogger
{
    /** @var string $tableName */
    public $tableName;

    /** @var array $queryTypes */
    public $queryExcludeTypes = [];

    /** @var Db $db */
    public $db;

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

        $this->db->execute($logSql);
    }
}