<?php

namespace App\Tier\DAL;

use App\Tier\BO\ClientBO;
use Doctrine\DBAL\Connection;

class ClientDAL
{
    private $helper;

    public function __construct(Connection $connection)
    {
        $this->helper = new DataHelper($connection, 'client', ClientBO::class);
    }

    public function persist(ClientBO $client) : ClientBO
    {
        return $this->helper->persist($client);
    }

    public function getById(int $id) : ClientBO
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
            $clients[] = $this->helper->sourceToBO($row, new ClientBO());
        }

        return $clients;
    }

}