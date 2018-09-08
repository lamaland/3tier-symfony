<?php

namespace App\Domain;

use App\DataTransfer\Invoice;
use App\Adapter\InvoiceAdapterInterface;

class InvoiceDomain
{
    const PRICE = 15.90;
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
        $invoice->date = new \DateTime();
        $this->validate($invoice);
        $this->calculateAmount($invoice);
        return $this->invoiceAdapter->persist($invoice);
    }

    private function calculateAmount(Invoice $invoice)
    {
        $invoice->price = self::PRICE;
        $invoice->amount = $invoice->quantity * $invoice->price;
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