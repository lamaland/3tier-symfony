<?php

namespace App\Tier\DAL;

use App\Tier\BO\InvoiceBO;

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
        return self::insert(self::$tableName,$invoice,self::$columns);
    }

    public static function getById(int $id) : InvoiceBO
    {
        $query = self::getConnection()->createQueryBuilder()
                 ->select('*')
                 ->from(self::$tableName)
                 ->where('id = :id')
                 ->setParameter('id',$id)
                 ->execute();

        self::handleZeroResults($stmt, 'Invoice id='.$id.' not found.');

        return self::sourceToBO($stmt->fetch(),self::$columns,new InvoiceBO());
    }

    public static function getByIdClient(int $idClient) : array
    {
        $query = self::getConnection()->createQueryBuilder()
                 ->select('*')
                 ->from(self::$tableName)
                 ->where('idClient = :idClient')
                 ->setParameter('idClient',$idClient)
                 ->execute();
        
        $invoices = [];
        while ($source = $query->fetch()) {
            $invoices[] = self::sourceToBO($source,self::$columns,new InvoiceBO());
        }

        return $invoices;
    }
}