<?php

namespace App\Tier\BLL;

use App\Tier\BO\ClientBO;
use App\Tier\DAL\ClientDAL;
use App\Tier\BLL\InvoiceBLL;

class ClientBLL
{
    private function validate(ClientBO $client) : void
    {
        if ('' === $client->firstName)    { throw new \Exception('First name cannot be blank.', 400); }
        if ('' === $client->lastName)     { throw new \Exception('Last name cannot be blank.', 400); }
    }

    public function create(ClientBO $client) : ClientBO
    {
        $this->validate($client);

        ClientDAL::create($client);

        $invoiceBLL = new InvoiceBLL();

        foreach ($client->invoices as $invoice)
        {
            $invoiceBLL->create($invoice);
        }

        return $client;
    }

    public function get(int $id) : ClientBO
    {
        $invoiceBLL = new InvoiceBLL();

        $client = ClientDAL::get($id);
        $client->invoices = $invoiceBLL->getByIdClient($client->id);

        return $client;
    }
}