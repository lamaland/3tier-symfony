<?php

namespace App\Adapter\DBAL;

use App\Adapter\ClientAdapterInterface;
use App\DataTransfer\Client;
use Doctrine\DBAL\Connection;

class ClientAdapterDBAL implements ClientAdapterInterface
{
    private $helper;

    public function __construct(Connection $connection)
    {
        $this->helper = new DBALHelper($connection, 'client', Client::class);
    }

    public function persist(Client $client) : Client
    {
        return $this->helper->persist($client);
    }

    public function getById(int $id) : Client
    {
        return $this->helper->selectOne($id);
    }

    public function getAll() : array
    {
        $source = $this->helper->createQueryBuilder()
                  ->select('*')
                  ->from($this->helper->getTableName())
                  ->execute();

        $clients = [];
        while ($row = $source->fetch()) {
            $clients[] = $this->helper->sourceToDTO($row, new Client());
        }

        return $clients;
    }

}