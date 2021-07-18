<?php

namespace jin2chen\ApiBundle\Response\ExceptionConverter;

use jin2chen\ApiBundle\Response\ExceptionConverterInterface;
use Throwable;

class GenericConverter implements ExceptionConverterInterface
{
    public function convert(Throwable $e): array
    {
        return [
            'status' => 500,
            'code' => 0,
            'message' => 'Internal Service Error.',
        ];
    }
}
