<?php

namespace jin2chen\ApiBundle\Tests\Response;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ExceptionConverterTest extends WebTestCase
{
    public function testConvert()
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/http-exception');
        $response = $client->getResponse();

        $this->assertEquals('{"status":404,"code":0,"message":"Not Found."}', $response->getContent());
    }
}
