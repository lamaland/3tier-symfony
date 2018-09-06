<?php

namespace App\Tier\BLL;

use App\Tier\BO\ClientBO;
use App\Tier\DAL\ClientDAL;

class ClientBLL
{
    private $clientDAL;
    private $invoiceBLL;

    public function __construct(ClientDAL $clientDAL, InvoiceBLL $invoiceBLL)
    {
        $this->clientDAL = $clientDAL;
        $this->invoiceBLL = $invoiceBLL;
    }

    private function validate(ClientBO $client) : void
    {
        if ('' === $client->firstName)    { throw new \Exception('First name cannot be blank.', 400); }
        if ('' === $client->lastName)     { throw new \Exception('Last name cannot be blank.', 400); }
    }

    public function create(ClientBO $client) : ClientBO
    {
        $this->validate($client);
        $this->clientDAL->persist($client);

        foreach ($client->invoices as $invoice) {
            $invoice->idClient = $client->id;
            $this->invoiceBLL->create($invoice);
        }

        return $client;
    }

    public function getById(int $id) : ClientBO
    {
        $client = $this->clientDAL->getById($id);
        $client->invoices = $this->invoiceBLL->getByIdClient($client->id);
        return $client;
    }

    public function getAll() : array
    {
        $clients = $this->clientDAL->getAll();

        foreach ($clients as $client) {
            $client->invoices = $this->invoiceBLL->getByIdClient($client->id);
        }

        return $clients;
    }

}