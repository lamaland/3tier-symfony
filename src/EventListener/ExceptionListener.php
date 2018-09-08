<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception  = $event->getException();
        $code       = $exception->getCode();
        $message    = $exception->getMessage();
        $stackTrace = explode('#',$exception->getTraceAsString());

        if ($code == 0) { $code = 500; }

        $event->setResponse(new Response(json_encode([
            'message' => $message,
            'code' => $code,
            'stackTrace' => $stackTrace
        ]), (int) $code, ['Content-type' => 'application/json']));
    }
}