<?php

namespace jin2chen\ApiBundle\Tests\Response\Serializer;

use jin2chen\ApiBundle\Response\Serializer\ArraySerializer;
use PHPUnit\Framework\TestCase;

class ArraySerializerTest extends TestCase
{
    private ArraySerializer $serializer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->serializer = new ArraySerializer();
    }

    public function testCollection()
    {
        $data = ['foo' => 'bar'];

        $this->assertEquals($data, $this->serializer->collection(null, $data));
        $this->assertEquals(['item' => $data], $this->serializer->collection('item', $data));
    }

    public function testItem()
    {
        $data = ['foo' => 'bar'];

        $this->assertEquals($data, $this->serializer->item(null, $data));
        $this->assertEquals(['item' => $data], $this->serializer->item('item', $data));
    }
}
