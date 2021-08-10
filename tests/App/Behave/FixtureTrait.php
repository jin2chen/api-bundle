<?php

namespace jin2chen\ApiBundle\Tests\App\Behave;

use jin2chen\ApiBundle\Tests\App\Fixture\BookFixture;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @method ContainerInterface getContainer()
 */
trait FixtureTrait
{
    private function bookFixture(): BookFixture
    {
        return $this->getContainer()->get(BookFixture::class);
    }
}
