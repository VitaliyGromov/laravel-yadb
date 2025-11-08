<?php

declare(strict_types=1);

namespace App\Data\Contracts;

interface DataTransferObject
{
    /**
     * @return non-empty-array<string, string>
     */
    public function toArray(): array;
}
