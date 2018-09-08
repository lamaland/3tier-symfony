<?php

namespace App\Controller;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Domain\ClientDomain;
use App\DataTransfer\Client;
use App\Domain\InvoiceDomain;

class ClientController extends BaseController
{
    private $clientBLL;
    private $invoiceBLL;

    public function __construct(SerializerInterface $serializer, ClientDomain $clientBLL, InvoiceDomain $invoiceBLL)
    {
        $this->clientBLL = $clientBLL;
        $this->invoiceBLL = $invoiceBLL;
        parent::__construct($serializer);
    }

    /**
     * @Route(path="/clients", methods={"POST"})
     */
    public function createClient(Request $request) : Response
    {
        $client = $this->deserialize($request);
        $client = $this->clientBLL->create($client);
        return $this->response($client, 201);
    }

    /**
     * @Route(path="/clients", methods={"GET"})
     */
    public function getClients() : Response
    {
        $client = $this->clientBLL->getAll();
        return $this->response($client, 200);
    }

    /**
     * @Route(path="/clients/{id}", methods={"GET"})
     */
    public function getClient($id) : Response
    {
        $client = $this->clientBLL->getById($id);
        return $this->response($client, 200);
    }

    /**
     * @Route(path="/clients/{id}/invoices", methods={"GET"})
     */
    public function getClientInvoices($id) : Response
    {
        $invoices = $this->invoiceBLL->getByIdClient($id);
        return $this->response($invoices, 200);
    }

    private function deserialize(Request $request, string $format='json') : Client
    {
        return $this->serializer->deserialize($request->getContent(), Client::class, $format);
    }
}