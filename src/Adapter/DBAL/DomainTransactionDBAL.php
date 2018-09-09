<?php

namespace App\Adapter\DBAL;

use App\Adapter\DomainTransactionInterface;
use Doctrine\DBAL\Connection;

class DomainTransactionDBAL implements DomainTransactionInterface
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection   = $connection;
    }

    public function beginTransaction()
    {
        if (false === $this->connection->isTransactionActive()){
            $this->connection->beginTransaction();
        }
    }

    public function commitTransaction()
    {
        if (false === $this->connection->isTransactionActive()){
            $this->connection->commit();
        }
    }

    public function rollbackTransaction()
    {
        if ($this->connection->isTransactionActive()){
            $this->connection->rollBack();
        }
    }
}