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
    public function createClient(Request $request, ClientDomain $clientBLL, SerializerInterface $serializer)
    {
        $client = $serializer->deserialize($request->getContent(), Client::class, 'json');
        return [201, $clientBLL->create($client)];
    }

    public function getClients(ClientDomain $clientBLL)
    {
        return [200, $clientBLL->getAll()];
    }

    public function getClient($id, ClientDomain $clientBLL)
    {
        return [200, $clientBLL->getById($id)];
    }

    public function getClientInvoices($id, InvoiceDomain $invoiceBLL)
    {
        return [200, $invoiceBLL->getByIdClient($id)];
    }
}