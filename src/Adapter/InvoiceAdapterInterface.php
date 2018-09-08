<?php

namespace App\Adapter;

use App\DataTransfer\Invoice;
use Doctrine\DBAL\Connection;

interface InvoiceAdapterInterface
{
    public function __construct(Connection $connection);

    public function persist(Invoice $invoice) : Invoice;

    public function getById(int $id) : Invoice;

    public function getByIdClient(int $idClient) : array;
}