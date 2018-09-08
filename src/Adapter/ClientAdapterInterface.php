<?php

namespace App\Adapter;

use App\DataTransfer\Client;
use Doctrine\DBAL\Connection;

interface ClientAdapterInterface
{
    public function __construct(Connection $connection);

    public function persist(Client $client) : Client;

    public function getById(int $id) : Client;

    public function getAll() : array;
}