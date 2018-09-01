<?php

namespace App\Controller;

use App\Controller\BaseController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Tier\BLL\ClientBLL;
use App\Tier\BO\ClientBO;

class ClientController extends BaseController
{
    /** @var ClientBLL $clientBLL */
    private $clientBLL;

    public function __construct(SerializerInterface $serializer)
    {
        $this->clientBLL = new ClientBLL();
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

    /** @Route(path="/clients/{id}", methods={"GET"}) */
    public function getClient($id) : Response
    {
        try {
            $client = $this->clientBLL->get($id);
        } catch(\Exception $exception) {
            return $this->response($exception);
        }

        return $this->response($client, 200);
    }

    private function deserialize(Request $request, string $format='json') : ClientBO
    {
        return $this->serializer->deserialize($request->getContent(), ClientBO::class, $format);
    }
}