<?php

namespace jin2chen\ApiBundle\Tests\Response\Type;

use jin2chen\ApiBundle\Response\Transformer\ArrayTransformer;
use jin2chen\ApiBundle\Response\Type\CollectionType;
use jin2chen\ApiBundle\Tests\App\Behave\FixtureTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CollectionTypeTest extends KernelTestCase
{
    use FixtureTrait;

    public function testGetResource()
    {
        $books = $this->bookFixture()->books();
        $type = new CollectionType($books, ArrayTransformer::class);

        $this->assertEquals($books, $type->getResource());
    }
}
