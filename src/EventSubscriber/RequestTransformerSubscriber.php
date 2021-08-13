<?php

declare(strict_types=1);

namespace jin2chen\ApiBundle\EventSubscriber;

use JsonException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

use function is_array;
use function json_decode;

use const JSON_THROW_ON_ERROR;

class RequestTransformerSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 1023],
        ];
    }

    /**
     * @Callback
     * @see getSubscribedEvents()
     * @param RequestEvent $event
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (false === $this->supports($request)) {
            return;
        }

        try {
            /** @var array|scalar $data */
            $data = json_decode((string) $request->getContent(), true, 512, JSON_THROW_ON_ERROR);

            if (is_array($data)) {
                $request->request->replace($data);
            }
        } catch (JsonException $exception) {
            throw new BadRequestHttpException($exception->getMessage());
        }
    }

    private function supports(Request $request): bool
    {
        return 'json' === $request->getContentType() && $request->getContent();
    }
}
