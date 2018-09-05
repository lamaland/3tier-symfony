<?php

namespace App\Tier\DAL;

use App\Tier\BO\InvoiceBO;
use Doctrine\DBAL\Connection;

class InvoiceDAL
{
    private $helper;

    public function __construct(Connection $connection)
    {
        $this->helper = new DataHelper(
            InvoiceBO::class,
            'invoice',
            ['idClient','date','quantity'],
            $connection
        );
    }

    public function persist(InvoiceBO $invoice) : InvoiceBO
    {
        return $this->helper->insert($invoice);
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