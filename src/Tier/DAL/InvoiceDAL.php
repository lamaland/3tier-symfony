<?php

namespace App\Tier\DAL;

use App\Tier\BO\InvoiceBO;

class InvoiceDAL
{
    private static function sourceToBO($source) : InvoiceBO
    {
        $invoice = new InvoiceBO();

        $invoice->idClient  = $source['idClient'];
        $invoice->date      = $source['date'];
        $invoice->quantity  = $source['quantity'];

        return $invoice;
    }

    public static function create(InvoiceBO $invoice) : InvoiceBO
    {
        // Do the db job here to persist data on base ... whatever
        return $invoice;
    }

    public static function get(int $id) : InvoiceBO
    {
        // Do the db job here to get data from base ... whatever
        self::sourceToBO($source);

        return new InvoiceBO();
    }

    public static function getByIdClient(int $idClient) : array
    {
        $invoices = [];

        // Do the db job here to get data from base ... whatever
        foreach ($sourceArray as $source) {
            $invoices = self::sourceToBO($source);
        }        

        return new InvoiceBO();
    }
}