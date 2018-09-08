<?php

namespace App\Adapter\DBAL;

use App\Adapter\InvoiceAdapterInterface;
use App\DataTransfer\Invoice;
use Doctrine\DBAL\Connection;

class InvoiceAdapterDBAL implements InvoiceAdapterInterface
{
    private $helper;

    public function __construct(Connection $connection)
    {
        $this->helper = new \App\Adapter\DBAL\DBALHelper($connection, 'invoice', Invoice::class);
    }

    public function persist(Invoice $invoice) : Invoice
    {
        return $this->helper->persist($invoice);
    }

    public function getById(int $id) : Invoice
    {
        return $this->helper->selectOne($id);
    }

    public function getByIdClient(int $idClient) : array
    {
        return $this->helper->selectBy('idClient', $idClient);
    }
}