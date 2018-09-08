<?php

namespace App\Adapter\DBAL;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class DBALHelper
{
    private $connection;
    private $BOClass;
    private $tableName;

    public function __construct(Connection $connection, string $tableName, string $BOClass)
    {
        $this->connection   = $connection;
        $this->tableName    = $tableName;
        $this->BOClass      = $BOClass;
    }

    public function getTableName() : string
    {
        return $this->tableName;
    }

    public function getConnection() : Connection
    {
        return $this->connection;
    }

    public function createQueryBuilder() : QueryBuilder
    {
        return $this->connection->createQueryBuilder();
    }

    public function getColumns() : array
    {
        return $this->connection->getSchemaManager()->listTableColumns($this->tableName);
    }

    public function selectBy($key, $value)
    {
        $query = $this->connection->createQueryBuilder()
               ->select('*')
               ->from($this->tableName)
               ->where("$key = :key")
               ->setParameter('key',$value)
               ->execute();

        $collection = [];
        while ($row = $query->fetch()) {
            $collection[] = $this->sourceToBO($row, new $this->BOClass());
        }

        return $collection;
    }

    public function selectOne($value)
    {
        $result = $this->selectBy('id', $value);

        if (0 === count($result)) {
            throw new \Exception("$this->tableName id=$value not found",404);
        }

        return $result[0];
    }

    public function persist($bo)
    {
        if ($bo->id > 0) {
            return $this->update($bo);
        } else {
            return $this->insert($bo);
        }
    }

    public function insert($bo)
    {
        $query = $this->connection->createQueryBuilder()
                      ->insert($this->tableName);

        foreach($this->getColumns() as $column)
        {
            $columnName = $column->getName();
            $query->setValue($columnName, ":$columnName")
                  ->setParameter($columnName, $bo->{$columnName});
        }

        $query->execute();

        $bo->id = $this->connection->lastInsertId();
        
        return $bo;
    }

    public function update($bo)
    {
        $query = $this->connection->createQueryBuilder()
                      ->update($this->tableName, 't')
                      ->where("id = :id")
                      ->setParameter('id', $bo->id);

        foreach($this->getColumns() as $column)
        {
            $columnName = $column->getName();
            $query->set("t.$columnName", ":$columnName")
                  ->setParameter($columnName, $bo->{$columnName});
        }

        $query->execute();

        return $bo;
    }

    public function sourceToBO($source, $bo)
    {
        $bo->id = $source['id'];
        foreach($this->getColumns() as $column) {
            $bo->{$column->getName()} = $source[$column->getName()];
        }
        return $bo;
    }
}