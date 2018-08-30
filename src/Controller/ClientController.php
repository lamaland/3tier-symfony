<?php

namespace App\Controller;

use App\Tier\BLL\ClientBLL;
use App\Tier\BO\ClientBO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route('')
     */
    public function createClient(Request $request)
    {
        $client = $serializer->deserialize($request,ClientBO::class,'json');
        $client = $this->clientBLL->create($client);
        return new JsonResponse($serializer->serialize($client,'json'));
    }
}