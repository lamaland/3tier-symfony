<?php

namespace App\Tier\DAL;

class DAL
{
    protected static function getConnection() : \Doctrine\DBAL\Connection
    {
       return \Doctrine\DBAL\DriverManager::getConnection(['url' => 'mysql://root:root@db/api'], new \Doctrine\DBAL\Configuration());
    }

    protected static function handleZeroResults($stmt, $message) : void
    {
        if (0 === $stmt->rowCount()) {
            throw new \Exception($message,404);
        }
    }

    protected static function insert($table, $bo, $columns)
    {
        $conn = self::getConnection();
        $query = $conn->createQueryBuilder()
                 ->insert($table)
                 ->values(self::BOToSource($columns, $bo))
                 ->execute();
        $bo->id = $conn->lastInsertId();
        
        return $bo;
    }

    protected static function BOToSource($columns, $bo) : array
    {
        foreach($columns as $column) {
            $values[$column] = '\''.$bo->{$column}.'\'';
        }
        return $values;
    }

    protected static function sourceToBO($source, $columns, $bo) : object
    {
        $bo->id = $source['id'];
        foreach($columns as $column) {
            $bo->{$column} = $source[$column];
        }
        return $bo;
    }
}