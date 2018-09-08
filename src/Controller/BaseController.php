<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractController
{
    protected $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    protected function serialize($client, string $format='json') : string
    {
        return $this->serializer->serialize($client, $format);
    }

    protected function response($response, int $status=200, string $contentType='application/json')
    {
        return new Response($this->serialize($response), $status, ['Content-type' => $contentType]);
    }
}