<?php

namespace jin2chen\ApiBundle\Tests\Controller;

use jin2chen\ApiBundle\Controller\ApiController;
use jin2chen\ApiBundle\Response\ResponseConverter;
use jin2chen\ApiBundle\Tests\App\Behave\FixtureTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiControllerTest extends WebTestCase
{
    use FixtureTrait;

    public function testGetSubscribedServices()
    {
        $this->assertContains(ResponseConverter::class, ApiController::getSubscribedServices());
    }

    public function testView()
    {
        $response = $this->request(Request::METHOD_GET, '/books/1');

        $book = $this->bookFixture()->book(1);
        $this->assertEquals(json_encode($book), $response->getContent());
    }

    public function testIndex()
    {
        $response = $this->request(Request::METHOD_GET, '/books');

        $books = $this->bookFixture()->books();
        $this->assertEquals(
            json_encode($books),
            $response->getContent()
        );
    }

    private function request(string $method, string $uri): Response
    {
        $client = static::createClient();
        $client->request($method, $uri);

        return $client->getResponse();
    }
}
