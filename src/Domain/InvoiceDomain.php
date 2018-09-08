<?php

namespace App\Domain;

use App\DataTransfer\Invoice;
use App\Adapter\InvoiceAdapterInterface;

class InvoiceDomain
{
    private $invoiceAdapter;

    public function __construct(InvoiceAdapterInterface $invoiceAdapter)
    {
        $this->invoiceAdapter = $invoiceAdapter;
    }

    private function validate(Invoice $invoice) : void
    {
        if (0 >= $invoice->quantity) { throw new \Exception('Quantity cannot be less or equal to zero', 400); }
    }

    public function create(Invoice $invoice) : Invoice
    {
        $this->validate($invoice);
        return $this->invoiceAdapter->persist($invoice);
    }

    public function getById($id) : Invoice
    {
        return $this->invoiceAdapter->getById($id);
    }

    public function getByIdClient($idClient) : array
    {
        return $this->invoiceAdapter->getByIdClient($idClient);
    }
}