<?php

namespace jin2chen\ApiBundle\Tests\Response\ExceptionConverter;

use Exception;
use jin2chen\ApiBundle\Response\ExceptionConverter\GenericConverter;
use Monolog\Test\TestCase;

class GenericConverterTest extends TestCase
{
    public function testConvert()
    {
        $expect = [
            'status' => 500,
            'code' => 0,
            'message' => 'Internal Service Error.',
        ];

        $throwable = new Exception('Invalid.');
        $convert = new GenericConverter();
        $this->assertEquals($expect, $convert->convert($throwable));
    }
}
