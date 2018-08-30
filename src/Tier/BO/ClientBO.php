<?php

namespace App\Tier\BO;

use App\Tier\BO\InvoiceBO;

class ClientBO
{
    /** @var string $firstName */       public $firstName;
    /** @var string $lastName */        public $lastName;
    /** @var BO_Invoice[] $invoices */  public $invoices;
}