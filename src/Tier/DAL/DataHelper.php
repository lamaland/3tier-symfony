<?php

namespace App\Tier\DAL;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class DataHelper
{
    private $connection;
    private $BOClass;
    public $tableName;
    public $columns;

    public function __construct(string $BOClass, string $tableName, array $columns, Connection $connection)
    {
        $this->BOClass      = $BOClass;
        $this->connection   = $connection;
        $this->tableName    = $tableName;
        $this->columns      = $columns;
    }

    public function getConnection() : Connection
    {
        return $this->connection;
    }

    public function createQueryBuilder() : QueryBuilder
    {
        return $this->connection->createQueryBuilder();
    }

    public function selectBy($key, $value)
    {
        $query = $this->connection->createQueryBuilder()
               ->select('*')
               ->from($this->tableName)
               ->where($key.' = :key')
               ->setParameter('key',$value)
               ->execute();

        $collection = [];
        while ($row = $query->fetch()) {
            $invoices[] = $this->sourceToBO($row, new $this->BOClass());
        }

        return $collection;
    }

    public function selectOne($value)
    {
        $query = $this->selectBy('id', $value);

        if (0 === $query->rowCount()) {
            throw new \Exception("$this->tableName id=$value not found",404);
        }

        return $this->sourceToBO($query->fetch(), new $this->BOClass());
    }

    public function insert($bo)
    {
        $this->connection->createQueryBuilder()
             ->insert($this->tableName)
             ->values(self::BOToSource($bo))
             ->execute();

        $bo->id = $this->connection->lastInsertId();
        
        return $bo;
    }

    public function update($bo)
    {
        $query = $this->connection->createQueryBuilder()
                      ->update($this->tableName, 't')
                      ->where("id = :id")
                      ->setParameter('id',$bo->id);

        foreach($this->columns as $column) {
            $query->set("t.$column",":$column")
                  ->setParameter($column,$bo->{$column});
        }

        $query->values(self::BOToSource($bo))
              ->execute();

        return $bo;
    }

    public function BOToSource($bo) : array
    {
        $values = [];
        foreach($this->columns as $column) {
            $values[$column] = $bo->{$column};
        }
        return $values;
    }

    public function sourceToBO($source, $bo)
    {
        $bo->id = $source['id'];
        foreach($this->columns as $column) {
            $bo->{$column} = $source[$column];
        }
        return $bo;
    }
}