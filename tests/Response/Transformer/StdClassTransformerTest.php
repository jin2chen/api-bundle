<?php

namespace jin2chen\ApiBundle\Tests\Response\Transformer;

use jin2chen\ApiBundle\Response\Transformer\StdClassTransformer;
use PHPUnit\Framework\TestCase;
use stdClass;

class StdClassTransformerTest extends TestCase
{
    public function testTransform()
    {
        $expect = [];
        $transformer = new StdClassTransformer();
        $this->assertEquals($expect, $transformer->transform(new stdClass()));
    }
}
