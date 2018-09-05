<?php

namespace App\Tier\DAL;

use App\Tier\BO\InvoiceBO;
use Doctrine\DBAL\Connection;

class InvoiceDAL
{
    private $helper;

    public function __construct(Connection $connection)
    {
        $this->helper = new DataHelper($connection, 'invoice', InvoiceBO::class);
    }

    public function persist(InvoiceBO $invoice) : InvoiceBO
    {
        return $this->helper->persist($invoice);
    }

    public function getById(int $id) : InvoiceBO
    {
        return $this->helper->selectOne($id);
    }

    public function getByIdClient(int $idClient) : array
    {
        return $this->helper->selectBy('idClient', $idClient);
    }
}