<?php

namespace App\Adapter\DBAL;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class DBALHelper
{
    private $connection;
    private $DTOClass;
    private $tableName;

    public function __construct(Connection $connection, string $tableName, string $DTOClass)
    {
        $this->connection   = $connection;
        $this->tableName    = $tableName;
        $this->DTOClass      = $DTOClass;
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
            $collection[] = $this->sourceToBO($row, new $this->DTOClass());
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

    public function persist($dto)
    {
        if ($dto->id > 0) {
            return $this->update($dto);
        } else {
            return $this->insert($dto);
        }
    }

    public function insert($dto)
    {
        $query = $this->connection->createQueryBuilder()
                      ->insert($this->tableName);

        foreach($this->getColumns() as $column)
        {
            $columnName = $column->getName();
            $query->setValue($columnName, ":$columnName")
                  ->setParameter($columnName, $dto->{$columnName});
        }

        $query->execute();

        $dto->id = $this->connection->lastInsertId();
        
        return $dto;
    }

    public function update($dto)
    {
        $query = $this->connection->createQueryBuilder()
                      ->update($this->tableName, 't')
                      ->where("id = :id")
                      ->setParameter('id', $dto->id);

        foreach($this->getColumns() as $column)
        {
            $columnName = $column->getName();
            $query->set("t.$columnName", ":$columnName")
                  ->setParameter($columnName, $dto->{$columnName});
        }

        $query->execute();

        return $dto;
    }

    public function sourceToDTO($source, $dto)
    {
        $dto->id = $source['id'];
        foreach($this->getColumns() as $column) {
            $dto->{$column->getName()} = $source[$column->getName()];
        }
        return $dto;
    }
}