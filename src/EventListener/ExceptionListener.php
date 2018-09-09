<?php

namespace App\EventListener;

use App\Adapter\DomainTransactionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ExceptionListener
{
    private $serializer;
    private $transaction;

    public function __construct(SerializerInterface $serializer, DomainTransactionInterface $transaction)
    {
        $this->serializer = $serializer;
        $this->transaction = $transaction;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception  = $event->getException();

        $this->transaction->rollbackTransaction();

        $code       = $exception->getCode(); if ($code === 0) { $code = 500; }
        $message    = $exception->getMessage();
        $stackTrace = explode(PHP_EOL,$exception->getTraceAsString());

        $event->setResponse(new Response($this->serializer->serialize([
            'message' => $message,
            'code' => $code,
            'stackTrace' => $stackTrace
        ],'json'), (int) $code, ['Content-type' => 'application/json']));
    }
}