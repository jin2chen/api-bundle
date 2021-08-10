<?php

declare(strict_types=1);

namespace jin2chen\ApiBundle\Tests\EventSubscriber;

use jin2chen\ApiBundle\EventSubscriber\RequestTransformerSubscriber;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;

use function json_encode;

class RequestTransformerSubscriberTest extends WebTestCase
{
    public function testGetSubscribedEvents()
    {
        $this->assertEquals(
            [KernelEvents::REQUEST],
            array_keys(RequestTransformerSubscriber::getSubscribedEvents())
        );
    }

    public function testTransformRequest()
    {
        $body = json_encode(['foo' => 'baz']);

        $response = $this->sendRequest($body);

        $this->assertSame($body, $response->getContent());
    }

    public function testInvalidBody()
    {
        $response = $this->sendRequest('{$body}');

        $this->assertSame('{"message":"Syntax error"}', $response->getContent());
        $this->assertSame(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testInvalidContentType(): void
    {
        $body = json_encode(['foo' => 'baz']);

        $response = $this->sendRequest($body, 'application/javascript');

        $this->assertSame('[]', $response->getContent());
    }

    private function sendRequest(string $body, string $contentType = 'application/json'): Response
    {
        $client = static::createClient();

        $client->request(Request::METHOD_POST, '/json', [], [], ['CONTENT_TYPE' => $contentType], $body);

        return $client->getResponse();
    }
}
