<?php

namespace App\Controller;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Domain\ClientDomain;
use App\DataTransfer\Client;
use App\Domain\InvoiceDomain;

class ClientController
{
    private $clientBLL;
    private $invoiceBLL;
    private $serializer;

    public function __construct(ClientDomain $clientBLL, InvoiceDomain $invoiceBLL, SerializerInterface $serializer)
    {
        $this->clientBLL = $clientBLL;
        $this->invoiceBLL = $invoiceBLL;
        $this->serializer = $serializer;
    }

    public function createClient(Request $request)
    {
        $client = $this->serializer->deserialize(
            $request->getContent(),
            Client::class,
            'json'
        );
        return [201, $this->clientBLL->create($client)];
    }

    public function getClients()
    {
        return [200, $this->clientBLL->getAll()];
    }

    public function getClient($id)
    {
        return [200, $this->clientBLL->getById($id)];
    }

    public function getClientInvoices($id)
    {
        return [200, $this->invoiceBLL->getByIdClient($id)];
    }
}