<?php

namespace jin2chen\ApiBundle\Tests\App\Fixture;

use jin2chen\ApiBundle\Tests\App\Model\Book;

class BookFixture
{
    public function book(int $id  = null): Book
    {
        return new Book($id ?? 1, 'CSS in Depth', '2021');
    }

    /**
     * @return Book[]
     */
    public function books(): array
    {
        return [
            new Book(1, 'CSS in Depth', '2021'),
            new Book(2, 'Kubernetes in Action', '2019'),
        ];
    }
}
