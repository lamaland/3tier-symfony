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
        if ($response instanceOf \Exception)
        {
            $code       = $response->getCode();
            $message    = $response->getMessage();
            $stackTrace = explode('#',$response->getTraceAsString());

            if ($code == 0) { $code = 500; }

            return new Response(json_encode([
                'message' => $message,
                'code' => $code,
                'stackTrace' => $stackTrace
            ]), (int) $code, ['Content-type' => 'application/json']);
        }

        return new Response($this->serialize($response), $status, ['Content-type' => $contentType]);
    }
}