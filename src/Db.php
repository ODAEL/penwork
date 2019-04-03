<?php
declare(strict_types=1);

namespace Penwork;

use PDO;

class Db
{
    /** @var \PDO $pdo */
    protected $pdo;

    /** @var self $instance */
    protected static $instance;

    protected function __construct()
    {
        $dbConfig = require ROOT . '/config/db_config.php';
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $this->pdo = new PDO($dbConfig['dsn'], $dbConfig['user'], $dbConfig['pass'], $options);
    }

    public static function instance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
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
        $logger = QueryLogger::getLogger($this->pdo);

        if (!$logger) {
            return;
        }

        $logger->log($sql, $success);
    }
}