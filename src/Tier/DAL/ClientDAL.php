<?php

namespace App\Tier\DAL;

use App\Tier\BO\ClientBO;

class ClientDAL
{
    private static function sourceToBO($source) : ClientBO
    {
        $client = new ClientBO();

        $client->firstName  = $source['firstName'];
        $client->lastName   = $source['lastName'];

        return $client;
    }

    public static function create(ClientBO $client) : ClientBO
    {
        // Do the db job here to persist data on base ... whatever
        return $client;
    }

    public static function get(int $id) : ClientBO
    {
        // Do the db job here to get data from base ... whatever
        self::sourceToBO($source);

        return new ClientBO();
    }
}