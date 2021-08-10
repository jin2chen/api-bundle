<?php

namespace jin2chen\ApiBundle\Tests\Response\ExceptionConverter;

use Exception;
use InvalidArgumentException;
use jin2chen\ApiBundle\Response\ExceptionConverter\HttpExceptionConverter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class HttpExceptionConverterTest extends TestCase
{
    private HttpExceptionConverter $converter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->converter = new HttpExceptionConverter();
    }

    public function testInvalidThrowable()
    {
        $this->expectException(InvalidArgumentException::class);
        $throwable = new Exception('Invalid.');
        $this->converter->convert($throwable);
    }

    public function testConvertClientException()
    {
        $expect = [
            'status' => 404,
            'code' => 0,
            'message' => 'Not Found.',
        ];

        $throwable = new NotFoundHttpException('Not Found.');
        $this->assertEquals($expect, $this->converter->convert($throwable));
    }

    public function testConvertServerException()
    {
        $expect = [
            'status' => 503,
            'code' => 0,
            'message' => 'Service Unavailable.',
        ];

        $throwable = new ServiceUnavailableHttpException(null, 'Service Unavailable.');
        $this->assertEquals($expect, $this->converter->convert($throwable));
    }

    public function testAllNotClientStatusToServerStatus()
    {
        $throwable = new HttpException(199);
        $this->assertEquals(500, $this->converter->convert($throwable)['status']);

        $throwable = new HttpException(699);
        $this->assertEquals(500, $this->converter->convert($throwable)['status']);
    }
}
