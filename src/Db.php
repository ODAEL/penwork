<?php
declare(strict_types=1);

namespace Penwork;

use PDO;
use Penwork\Traits\SingletonTrait;

class Db extends BaseObject
{
    use SingletonTrait;

    /** @var PDO $pdo */
    protected $pdo;

    protected function __construct()
    {
        $dbConfigDsn = self::getConfigRequiredParams('db', 'dsn');
        $dbConfigUser = self::getConfigRequiredParams('db', 'user');
        $dbConfigPass = self::getConfigRequiredParams('db', 'pass');

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $this->pdo = new PDO($dbConfigDsn, $dbConfigUser, $dbConfigPass, $options);
    }

    public function execute(string $sql, array $params = []): bool
    {
        $statement = $this->pdo->prepare($sql);
        $result = $statement->execute($params);

        $this->logSql($sql, $result);

        return $result;
    }

    public function query(string $sql, array $params = []): array
    {
        $statement = $this->pdo->prepare($sql);
        $result = $statement->execute($params);

        $this->logSql($sql, $result);

        if ($result !== false) {
            return $statement->fetchAll();
        }

        return [];
    }

    public function logSql(string $sql, bool $success): void
    {
        $logger = self::getConfigParams('db', 'query_logger');

        if (!$logger) {
            return;
        }

        $logger->log($sql, $success);
    }
}