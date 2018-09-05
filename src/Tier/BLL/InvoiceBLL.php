<?php

namespace App\Tier\BLL;

use App\Tier\BO\InvoiceBO;
use App\Tier\DAL\InvoiceDAL;

class InvoiceBLL
{
    private $invoiceDAL;

    public function __construct(InvoiceDAL $invoiceDAL)
    {
        $this->invoiceDAL = $invoiceDAL;
    }

    private function validate(InvoiceBO $invoice) : void
    {
        if (0 >= $invoice->quantity) { throw new \Exception('Quantity cannot be less or equal to zero', 400); }
    }

    public function persist(InvoiceBO $invoice) : InvoiceBO
    {
        $this->validate($invoice);
        return $this->invoiceDAL->persist($invoice);
    }

    public function getById($id) : InvoiceBO
    {
        return $this->invoiceDAL->getById($id);
    }

    public function getByIdClient($idClient) : array
    {
        return $this->invoiceDAL->getByIdClient($idClient);
    }
}