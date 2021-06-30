<?php

declare(strict_types=1);

namespace jin2chen\ApiBundle\Tests;

use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AppTest extends KernelTestCase
{
    public function testContainer()
    {
        self::bootKernel();

        $this->assertInstanceOf(ContainerInterface::class, self::getContainer());
    }
}
