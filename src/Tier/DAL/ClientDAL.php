<?php

namespace App\Tier\DAL;

use App\Tier\BO\ClientBO;
use Doctrine\DBAL\Connection;

class ClientDAL
{
    private $helper;

    public function __construct(Connection $connection)
    {
        $this->helper = new DataHelper(
            ClientBO::class,
            'client',
            ['firstName','lastName','city'],
            $connection
        );
    }

    public function persist(ClientBO $client) : ClientBO
    {
        if (!$client->id >= 0) {
            return $this->helper->insert($client);
        } else {
            return $this->helper->update($client);
        }
    }

    public function getById(int $id) : ClientBO
    {
        return $this->helper->selectOne($id);
    }

    public function getAll() : array
    {
        $source = $this->helper->createQueryBuilder()
                 ->select('*')->from($this->helper->tableName)
                 ->execute();

        $clients = [];
        while ($row = $source->fetch()) {
            $clients[] = $this->helper->sourceToBO($row, new ClientBO());
        }

        return $clients;
    }

}