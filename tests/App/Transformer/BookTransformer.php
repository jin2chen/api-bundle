<?php

namespace jin2chen\ApiBundle\Tests\App\Transformer;

use jin2chen\ApiBundle\Tests\App\Model\Book;
use League\Fractal\TransformerAbstract;

class BookTransformer extends TransformerAbstract
{
    public function transform(Book $book): array
    {
        return [
            'id' => (int) $book->id,
            'title' => $book->title,
            'year' => $book->year,
        ];
    }
}
