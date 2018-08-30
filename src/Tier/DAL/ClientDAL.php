<?php

namespace App\Tier\DAL;

use App\Tier\BO\ClientBO;

class ClientDAL
{
    public static function create(ClientBO $client) : ClientBO
    {
        return $client;
    }
}