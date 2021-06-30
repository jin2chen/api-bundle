<?php

declare(strict_types=1);

namespace jin2chen\ApiBundle\EventSubscriber;

use Monolog\Processor\ProcessorInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Contracts\Service\ResetInterface;

use function is_null;

class RequestIdSubscriber implements EventSubscriberInterface, ProcessorInterface, ResetInterface
{
    private string $header = 'X-Request-Id';
    /**
     * @var array{request_id: string}
     */
    private array $data;

    public function __construct(?string $header = null)
    {
        $this->reset();
        if (!is_null($header)) {
            $this->header = $header;
        }
    }

    public function __invoke(array $record): array
    {
        /** @var array{extra: array} $record */
        $record['extra']['request_id'] = $this->data['request_id'];

        return $record;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onRequest', 1024],
            KernelEvents::RESPONSE => 'onResponse',
            KernelEvents::TERMINATE => 'onTerminate',
        ];
    }

    /**
     * @Callback
     * @see getSubscribedEvents()
     */
    public function onRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ($request->headers->has($this->header)) {
            $this->data['request_id'] = (string) $request->headers->get($this->header);
            return;
        }

        $this->data['request_id'] = Uuid::uuid4()->toString();
        $request->headers->set($this->header, $this->data['request_id']);
    }

    /**
     * @Callback
     * @see getSubscribedEvents()
     * @param ResponseEvent $event
     */
    public function onResponse(ResponseEvent $event): void
    {
        $event->getResponse()->headers->set($this->header, $this->data['request_id']);
    }

    /**
     * @Callback
     * @see getSubscribedEvents()
     */
    public function onTerminate(): void
    {
        $this->reset();
    }

    final public function reset(): void
    {
        $this->data = [
            'request_id' => '',
        ];
    }
}
