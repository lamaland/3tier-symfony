<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Tier\BLL\ClientBLL;
use App\Tier\BO\ClientBO;

class ClientController
{
    /** @var ClientBLL $clientBLL */
    private $clientBLL;
    private $serializer;

    public function __construct()
    {
        $this->clientBLL = new ClientBLL();
        $this->serializer = $this->get('serializer');
    }

    /**
     * @Route(path="/clients", methods={"POST"})
     */
    public function createClient(Request $request) : JsonResponse
    {
        $client = $serializer->deserialize($request,ClientBO::class,'json');
        $client = $this->clientBLL->create($client);
        return new JsonResponse($serializer->serialize($client,'json'),201);
    }

    /**
     * @Route(path="/clients/{id}", methods={"GET"})
     */
    public function getClient(Request $request) : JsonResponse
    {
        $client = $this->clientBLL->get($client);
        return new JsonResponse($serializer->serialize($client,'json'),200);
    }
}