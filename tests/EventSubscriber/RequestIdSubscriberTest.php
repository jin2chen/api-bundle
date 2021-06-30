<?php

declare(strict_types=1);

namespace jin2chen\ApiBundle\Tests\EventSubscriber;

use jin2chen\ApiBundle\EventSubscriber\RequestIdSubscriber;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\KernelEvents;

use function array_keys;
use function sprintf;

class RequestIdSubscriberTest extends WebTestCase
{
    private string $requestIdParamName = 'jin2chen.api_bundle.request.request_id_header';

    /**
     * @test
     */
    public function getSubscribedEvents()
    {
        $this->assertEquals(
            [KernelEvents::REQUEST, KernelEvents::RESPONSE, KernelEvents::TERMINATE],
            array_keys(RequestIdSubscriber::getSubscribedEvents())
        );
    }

    /**
     * @test
     */
    public function onRequest()
    {

        $client = static::createClient();
        $client->request('post', '/json');
        $request = $client->getRequest();

        $requestIdHeader = static::getContainer()->getParameter($this->requestIdParamName);
        $this->assertTrue(Uuid::isValid($request->headers->get($requestIdHeader)));

        $requestId = Uuid::uuid4();
        $client->request('post', '/json', [], [], [sprintf('HTTP_%s', $requestIdHeader) => $requestId->toString()]);
        $request = $client->getRequest();
        $this->assertEquals($requestId->toString(), $request->headers->get($requestIdHeader));
    }

    /**
     * @test
     */
    public function onResponse()
    {
        $client = static::createClient();
        $client->request('post', '/json');
        $request = $client->getRequest();
        $response = $client->getResponse();

        $requestIdHeader = static::getContainer()->getParameter($this->requestIdParamName);
        $this->assertTrue(Uuid::isValid($request->headers->get($requestIdHeader)));
        $this->assertTrue(Uuid::isValid($response->headers->get($requestIdHeader)));
        $this->assertEquals($request->headers->get($requestIdHeader), $response->headers->get($requestIdHeader));
    }
}
