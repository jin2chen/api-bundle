<?php

namespace jin2chen\ApiBundle\Tests\App\Model;

use JsonSerializable;

class Book implements JsonSerializable
{
    public string $id;
    public string $title;
    public string $year;

    public function __construct(string $id, string $title, string $year)
    {
        $this->id = $id;
        $this->title = $title;
        $this->year = $year;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => (int) $this->id,
            'title' => $this->title,
            'year' => $this->year,
        ];
    }
}
