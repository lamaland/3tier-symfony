<?php

namespace App\Domain;

use App\Adapter\DomainTransactionInterface;
use App\DataTransfer\Client;
use App\Adapter\ClientAdapterInterface;
use Doctrine\DBAL\Connection;

class ClientDomain
{
    private $invoiceDomain;
    private $clientAdapter;
    private $transaction;

    public function __construct(InvoiceDomain $invoiceDomain, ClientAdapterInterface $clientAdapter, DomainTransactionInterface $transaction)
    {
        $this->invoiceDomain = $invoiceDomain;
        $this->clientAdapter = $clientAdapter;
        $this->transaction = $transaction;
    }

    private function validate(Client $client) : void
    {
        if ('' === $client->firstName)    { throw new \Exception('First name cannot be blank.', 400); }
        if ('' === $client->lastName)     { throw new \Exception('Last name cannot be blank.', 400); }
    }

    public function create(Client $client) : Client
    {
        $this->validate($client);

        $this->transaction->beginTransaction();

            $this->clientAdapter->persist($client);

            foreach ($client->invoices as $invoice)
            {
                $invoice->idClient = $client->id;
                $this->invoiceDomain->create($invoice);
            }

        $this->transaction->commitTransaction();

        return $client;
    }

    public function getById(int $id) : Client
    {
        $client = $this->clientAdapter->getById($id);
        $client->invoices = $this->invoiceDomain->getByIdClient($client->id);

        return $client;
    }

    public function getAll() : array
    {
        $clients = $this->clientAdapter->getAll();

        foreach ($clients as $client)
        {
            $client->invoices = $this->invoiceDomain->getByIdClient($client->id);
        }

        return $clients;
    }
}