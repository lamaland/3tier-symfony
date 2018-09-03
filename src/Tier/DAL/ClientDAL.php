<?php

namespace App\Tier\DAL;

use App\Tier\BO\ClientBO;

class ClientDAL extends DAL
{
    private static $tableName = 'client';
    private static $columns = [
        'firstName',
        'lastName',
        'city'
    ];

    public static function create(ClientBO $client) : ClientBO
    {
        return self::insert(self::$tableName, $client, self::$columns);
    }

    public static function getById(int $id) : ClientBO
    {
        $source = self::selectOne(self::$tableName, 'id', $id);

        self::handleZeroResults($source, 'Client id='.$id.' not found.');

        return self::sourceToBO($source->fetch(),self::$columns,new ClientBO());
    }

    public static function getAll() : array
    {
        $source = self::getConnection()->createQueryBuilder()
                 ->select('*')->from(self::$tableName)
                 ->execute();

        $clients = [];
        while ($row = $source->fetch()) {
            $clients[] = self::sourceToBO($row, self::$columns, new ClientBO());
        }

        return $clients;
    }

}