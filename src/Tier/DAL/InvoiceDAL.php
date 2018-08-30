<?php

namespace App\Tier\DAL;

use App\Tier\BO\InvoiceBO;

class InvoiceDAL
{
    public static function create(InvoiceBO $invoice) : InvoiceBO
    {
        return $invoice;
    }
}