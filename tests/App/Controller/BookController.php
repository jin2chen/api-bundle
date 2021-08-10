<?php

namespace jin2chen\ApiBundle\Tests\App\Controller;

use jin2chen\ApiBundle\Controller\ApiController;
use jin2chen\ApiBundle\Response\Type\CollectionType;
use jin2chen\ApiBundle\Response\Type\ObjectType;
use jin2chen\ApiBundle\Tests\App\Fixture\BookFixture;
use jin2chen\ApiBundle\Tests\App\Model\Book;
use jin2chen\ApiBundle\Tests\App\Transformer\BookTransformer;
use Symfony\Component\HttpFoundation\Response;

class BookController extends ApiController
{
    private BookFixture $fixture;

    public function __construct(BookFixture $fixture)
    {
        $this->fixture = $fixture;
    }

    public function view(int $id): Response
    {
        $book = $this->fixture->book($id);
        $resource = new ObjectType($book, BookTransformer::class);

        return $this->item($resource);
    }

    public function index(): Response
    {
        $collection = $this->fixture->books();
        $resource = new CollectionType($collection, BookTransformer::class, [], null);

        return $this->collection($resource);
    }
}
