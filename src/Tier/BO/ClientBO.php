<?php

namespace App\Tier\BO;

use App\Tier\BO\InvoiceBO;

class ClientBO
{
    /** @var int $id */                 public $id;
    /** @var string $firstName */       public $firstName;
    /** @var string $lastName */        public $lastName;
    /** @var BO_Invoice[] $invoices */  public $invoices;

    public function getDisplayName()
    {
        return implode(' ',[$this->firstName, $this->lastName]);
    }
}