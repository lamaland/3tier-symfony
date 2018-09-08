<?php

namespace App\DataTransfer;

use App\DataTransfer\Invoice;

class Client
{
    /** @var int            */ public $id;
    /** @var string         */ public $firstName;
    /** @var string         */ public $lastName;
    /** @var string         */ public $city;
    /** @var Invoice[]      */ public $invoices;

    public function getDisplayName()
    {
        return "$this->firstName $this->lastName";
    }
}