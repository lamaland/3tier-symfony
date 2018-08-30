<?php

namespace App\Tier\BLL;

use App\Tier\BO\InvoiceBO;

class InvoiceBLL
{
    private function validate(InvoiceBO $invoice) : void
    {
        if (0 >= $invoice->quantity) { throw new Exception('Quantity cannot be less or equal to zero'); }
    }

    public function create(InvoiceBO $invoice) : InvoiceBO
    {
        $this->validate($invoice);
        InvoiceDAL::create($invoice);
    }
}