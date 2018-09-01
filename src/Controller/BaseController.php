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

    protected function response($message, int $status=200, string $contentType='application/json')
    {
        if ($message instanceOf \Exception)
        {
            return new Response(json_encode([
                'message' => $message->getMessage(),
                'appCode' => $message->getCode(),
                'stackTrace' => explode('#',$message->getTraceAsString())
            ]), (int) $message->getCode(), ['Content-type' => $contentType]);
        }

        return new Response($this->serialize($message), $status, ['Content-type' => $contentType]);
    }
}