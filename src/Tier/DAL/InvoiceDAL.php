<?php

namespace App\Tier\DAL;

use App\Tier\BO\InvoiceBO;
use Doctrine\DBAL\ParameterType;

class InvoiceDAL extends DAL
{
    private static $tableName = 'invoice';
    private static $columns = [
        'idClient',
        'date',
        'quantity'
    ];

    public static function create(InvoiceBO $invoice) : InvoiceBO
    {
        return self::insert(self::$tableName, $invoice, self::$columns);
    }

    public static function getById(int $id) : InvoiceBO
    {
        $source = self::selectOne(self::$tableName, 'id', $id);

        return self::sourceToBO($source->fetch(), self::$columns, new InvoiceBO());
    }

    public static function getByIdClient(int $idClient) : array
    {
        $source = self::selectMany(self::$tableName, 'idClient', $idClient);
        
        $invoices = [];
        while ($row = $source->fetch()) {
            $invoices[] = self::sourceToBO($row, self::$columns, new InvoiceBO());
        }

        return $invoices;
    }
}