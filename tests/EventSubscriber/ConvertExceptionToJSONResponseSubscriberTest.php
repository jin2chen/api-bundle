<?php

namespace jin2chen\ApiBundle\Tests\EventSubscriber;

use jin2chen\ApiBundle\EventSubscriber\ConvertExceptionToJSONResponseSubscriber;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;

class ConvertExceptionToJSONResponseSubscriberTest extends WebTestCase
{
    public function testGetSubscribedEvents()
    {
        $this->assertEquals(
            [KernelEvents::EXCEPTION],
            array_keys(ConvertExceptionToJSONResponseSubscriber::getSubscribedEvents())
        );
    }

    public function testOnException()
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/exception');

        $response = $client->getResponse();
        $this->assertEquals(
            '{"status":500,"code":0,"message":"Internal Service Error."}',
            $response->getContent()
        );
    }
}
