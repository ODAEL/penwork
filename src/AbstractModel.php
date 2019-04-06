<?php
declare(strict_types=1);

namespace Penwork;

abstract class AbstractModel
{
    abstract protected static function getTableName(): string;

    abstract protected static function getIdTitle(): string;


    private static function getDbInstance(): Db
    {
        return Db::getInstance();
    }

    protected static function execute(string $sql, array $params = []): bool
    {
        $db = self::getDbInstance();
        return $db->execute($sql, $params);
    }

    protected static function query(string $sql, array $params = []): array
    {
        $db = self::getDbInstance();
        return $db->query($sql, $params);
    }


    public static function insert(array $fields = []): bool
    {
        $tableName = static::getTableName();
        $fieldStatement = self::prepareFieldsStatement($fields);

        return static::execute(
            "INSERT INTO $tableName $fieldStatement"
        );
    }

    public static function find(array $conditions = []): array
    {
        $tableName = static::getTableName();
        $conditionStatement = self::prepareConditionStatement($conditions);

        return static::query(
            "SELECT * FROM $tableName $conditionStatement"
        );
    }

    public static function update(array $fields = [], array $conditions = []): bool
    {
        $tableName = static::getTableName();
        $setStatement = self::prepareConditionStatement($fields, 'SET');
        $conditionStatement = self::prepareConditionStatement($conditions);

        return static::execute(
            "UPDATE $tableName $setStatement $conditionStatement"
        );
    }

    public static function delete(array $conditions = []): bool
    {
        $tableName = static::getTableName();
        $conditionStatement = self::prepareConditionStatement($conditions);

        return static::execute(
            "DELETE FROM $tableName $conditionStatement"
        );
    }


    public static function findAll(): array
    {
        return self::find([]);
    }

    public static function findLast(array $conditions = []): array
    {
        $result = self::find($conditions);

        return ($count = \count($result)) === 0 ? [] : $result[$count - 1];
    }

    public static function findById(int $id): array
    {
        return self::findLast([static::getIdTitle() => $id]);
    }

    public static function deleteByPk(int $id): bool
    {
        return self::delete([static::getIdTitle() => $id]);
    }

    public static function createByData(array $data): array
    {
        $result = self::insert($data);

        if ($result === false) {
            return [];
        }

        return self::findLast($data);
    }

    protected static function prepareConditionStatement(array $params = [], string $phrase = 'WHERE'): string
    {
        if ($params === []) {
            return '';
        }

        $conditions = [];
        foreach ($params as $field => $value) {
            $saveValue = addslashes((string)$value);
            $conditions[] = "$field = '$saveValue'";
        }
        $conditionString = implode(' AND ', $conditions);

       return "$phrase $conditionString";
    }

    protected static function prepareFieldsStatement(array $params = []): string
    {
        if ($params === []) {
            return '';
        }

        $fields = $values = [];
        foreach ($params as $field => $value) {
            $safeValue = addslashes((string)$value);
            $fields[] = $field;
            $values[] = "'$safeValue'";
        }
        $fieldsString = implode(', ', $fields);
        $valuesString = implode(', ', $values);

        return "($fieldsString) VALUES ($valuesString)";
    }

}