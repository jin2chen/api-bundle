<?php

namespace jin2chen\ApiBundle\Tests\Response\Transformer;

use jin2chen\ApiBundle\Response\Transformer\ArrayTransformer;
use PHPUnit\Framework\TestCase;

class ArrayTransformerTest extends TestCase
{
    public function testTransform()
    {
        $expect = [];
        $transformer = new ArrayTransformer();
        $this->assertEquals($expect, $transformer->transform($expect));
    }
}
