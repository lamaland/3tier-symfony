<?php

namespace App\Tier\BLL;

use App\Tier\BO\ClientBO;
use App\Tier\DAL\ClientDAL;
use App\Tier\DAL\InvoiceDAL;

class ClientBLL
{
    private function validate(ClientBO $client) : void
    {
        if ('' === $client->firstName)    { throw new \Exception('First name cannot be blank.'); }
        if ('' === $client->lastName)     { throw new \Exception('Last name cannot be blank.'); }
    }

    public function create(ClientBO $client) : ClientBO
    {
        $this->validate($client);

        ClientDAL::create($client);

        foreach ($client->invoices as $invoice)
        {
            InvoiceDAL::create($invoice);
        }
    }
}