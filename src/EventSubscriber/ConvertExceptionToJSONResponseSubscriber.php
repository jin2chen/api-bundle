<?php

declare(strict_types=1);

namespace jin2chen\ApiBundle\EventSubscriber;

use jin2chen\ApiBundle\Response\ExceptionConverter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

use const JSON_UNESCAPED_UNICODE;

class ConvertExceptionToJSONResponseSubscriber implements EventSubscriberInterface
{
    private ExceptionConverter $converter;

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onException', -32],
        ];
    }

    public function __construct(ExceptionConverter $converter)
    {
        $this->converter = $converter;
    }

    /**
     * @Callback
     *
     * @param ExceptionEvent $event
     */
    public function onException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();
        $result = $this->converter->convert($e);
        $response = new JsonResponse($result, $result['status']);
        $event->setResponse($response->setEncodingOptions(JSON_UNESCAPED_UNICODE));
    }
}
