<?php

namespace App\Controller;

use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Tier\BLL\ClientBLL;
use App\Tier\BO\ClientBO;
use App\Tier\BLL\InvoiceBLL;

class ClientController extends BaseController
{
    private $clientBLL;
    private $invoiceBLL;

    public function __construct(SerializerInterface $serializer, ClientBLL $clientBLL, InvoiceBLL $invoiceBLL)
    {
        $this->clientBLL = $clientBLL;
        $this->invoiceBLL = $invoiceBLL;
        parent::__construct($serializer);
    }

    /** @Route(path="/clients", methods={"POST"}) */
    public function createClient(Request $request) : Response
    {
        $client = $this->deserialize($request);
        
        try {
            $client = $this->clientBLL->create($client);
        } catch(\Exception $exception) {
            return $this->response($exception);
        }

        return $this->response($client, 201);
    }

    /** @Route(path="/clients", methods={"GET"}) */
    public function getClients() : Response
    {
       try {
            $client = $this->clientBLL->getAll();
        } catch(\Exception $exception) {
            return $this->response($exception);
        }

        return $this->response($client, 200);
    }

    /** @Route(path="/clients/{id}", methods={"GET"}) */
    public function getClient($id) : Response
    {
        try {
            $client = $this->clientBLL->getById($id);
        } catch(\Exception $exception) {
            return $this->response($exception);
        }

        return $this->response($client, 200);
    }

    /** @Route(path="/clients/{id}/invoices", methods={"GET"}) */
    public function getClientInvoices($id) : Response
    {
        try {
            $invoices = $this->invoiceBLL->getByIdClient($id);
        } catch(\Exception $exception) {
            return $this->response($exception);
        }

        return $this->response($invoices, 200);
    }

    private function deserialize(Request $request, string $format='json') : ClientBO
    {
        return $this->serializer->deserialize($request->getContent(), ClientBO::class, $format);
    }
}