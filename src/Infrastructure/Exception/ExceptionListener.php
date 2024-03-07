<?php

declare(strict_types=1);

namespace App\Infrastructure\Exception;

use App\Domain\Blog\Exception\PostValidation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event, string $eventName): void
    {
        // TODO: Cambiar cuando no es json

        $exception = $event->getThrowable();
        $data = [
            'title' => 'An error occurred',
            'detail' => $exception->getMessage(),
            'code' => $exception->getCode(),
        ];

        if ($exception instanceof PostValidation) {
            $violations = $exception->violations();
            if ($violations->count() > 0) {
                foreach ($violations as $violation) {
                    $data['errors'][] = [
                        'title' => $violation->getCause() ?? 'An error occurred',
                        'field' => $violation->getPropertyPath(),
                        'detail' => $violation->getMessage(),
                    ];
                }
            }
        }
        $response = new JsonResponse([], Response::HTTP_OK);
        $response->setData($data);

        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $event->setResponse($response);
    }
}
