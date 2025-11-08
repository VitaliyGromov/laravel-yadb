<?php

declare(strict_types=1);

namespace App\Data;

use App\Data\Contracts\DataTransferObject;
use ReflectionClass;
use ReflectionProperty;

abstract class Data implements DataTransferObject
{
    /**
     * @return non-empty-array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [];

        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $value = $property->getValue($this);

            if ($value === null) {
                continue;
            }

            $snakeCaseKey = $this->camelToSnakeCase($propertyName);

            $result[$snakeCaseKey] = $value;
        }

        return $result;
    }

    private function camelToSnakeCase(string $input): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }
}
