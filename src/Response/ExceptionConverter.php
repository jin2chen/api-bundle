<?php

declare(strict_types=1);

namespace jin2chen\ApiBundle\Response;

use jin2chen\ApiBundle\Response\ExceptionConverter\GenericConverter;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Throwable;

use function array_unshift;
use function class_parents;
use function get_class;

/**
 * @psalm-import-type ExceptionResponseArray from ExceptionConverterInterface
 */
final class ExceptionConverter implements ExceptionConverterInterface
{
    private ServiceLocator $converters;
    /**
     * @var array<string, string>
     */
    private array $mappings;

    /**
     * ExceptionConverter constructor.
     *
     * @param ServiceLocator $converters
     * @param array<string, string> $mappings
     */
    public function __construct(ServiceLocator $converters, array $mappings = [])
    {
        $this->converters = $converters;
        $this->mappings = $mappings;
    }

    /**
     * @param Throwable $e
     *
     * @return ExceptionConverterInterface
     */
    private function map(Throwable $e): ExceptionConverterInterface
    {
        /** @var class-string[] $classNames */
        $classNames = array_values(class_parents($e, false));
        array_unshift($classNames, get_class($e));
        $class = GenericConverter::class;
        foreach ($classNames as $className) {
            if (isset($this->mappings[$className])) {
                $class = $this->mappings[$className];
                break;
            }
        }

        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        /** @var ExceptionConverterInterface $service */
        $service = $this->converters->get($class);
        return $service;
    }

    /**
     * @return ExceptionResponseArray
     */
    public function convert(Throwable $e): array
    {
        return $this->map($e)->convert($e);
    }
}
