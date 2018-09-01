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
        $query = self::getConnection()->createQueryBuilder()
                 ->select('*')
                 ->from(self::$tableName)
                 ->where('id = :id')
                 ->setParameter('id',$id)
                 ->execute();

        self::handleZeroResults($query, 'Client id='.$id.' not found.');

        return self::sourceToBO($query->fetch(),self::$columns,new ClientBO());
    }
}