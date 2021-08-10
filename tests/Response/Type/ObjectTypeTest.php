<?php

namespace jin2chen\ApiBundle\Tests\Response\Type;

use jin2chen\ApiBundle\Response\Transformer\StdClassTransformer;
use jin2chen\ApiBundle\Response\Type\ObjectType;
use jin2chen\ApiBundle\Tests\App\Behave\FixtureTrait;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ObjectTypeTest extends KernelTestCase
{
    use FixtureTrait;

    public function testGetResource()
    {
        $book = $this->bookFixture()->book();
        $type = new ObjectType($book, StdClassTransformer::class);
        $this->assertEquals($book, $type->getResource());
    }

    public function testAbstractMethods()
    {
        $type = new ObjectType(new stdClass(), StdClassTransformer::class);
        $this->assertEquals(StdClassTransformer::class, $type->getTransformer());

        $type = $type->withKey('data');
        $this->assertEquals('data', $type->getKey());

        $type = $type->withIncludes('user,address');
        $this->assertEquals('user,address', $type->getIncludes());

        $type = $type->withIncludes(['user', 'address']);
        $this->assertEquals('user,address', $type->getIncludes());

        $type = $type->withMeta([]);
        $this->assertEquals([], $type->getMeta());
    }
}
