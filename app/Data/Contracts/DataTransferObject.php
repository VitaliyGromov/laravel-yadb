<?php

declare(strict_types=1);

namespace App\Data\Contracts;

interface DataTransferObject
{
    public function toArray(): array;
}
