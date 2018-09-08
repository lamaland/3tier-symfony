<?php

namespace App\DataTransfer;

class Invoice
{
    /** @var int        */ public $id;
    /** @var int        */ public $idClient;
    /** @var \DateTime  */ public $date;
    /** @var int        */ public $quantity;
    /** @var float      */ public $price;
    /** @var float      */ public $amount;
}