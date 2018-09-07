<?php

namespace App\Tier\BO;

class InvoiceBO
{
    /** @var int        */ public $id;
    /** @var int        */ public $idClient;
    /** @var \DateTime  */ public $date;
    /** @var int        */ public $quantity;
}