<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\Serializer\SerializerInterface;

class ResponseListener
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function onKernelView(GetResponseForControllerResultEvent $response)
    {
        $controllerResult = $response->getControllerResult();
        $response->setResponse(new Response($this->serializer->serialize(
            $controllerResult[1]
        ,'json'), $controllerResult[0], ['Content-type' => 'application/json']));
    }
}