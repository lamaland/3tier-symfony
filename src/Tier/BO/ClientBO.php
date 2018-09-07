<?php

namespace App\Tier\BO;

use App\Tier\BO\InvoiceBO;

class ClientBO
{
    /** @var int            */ public $id;
    /** @var string         */ public $firstName;
    /** @var string         */ public $lastName;
    /** @var string         */ public $city;
    /** @var InvoiceBO[]    */ public $invoices;

    public function getDisplayName()
    {
        return implode(' ',[$this->firstName, $this->lastName]);
    }
}