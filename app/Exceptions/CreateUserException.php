<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class CreateUserException extends Exception
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            "При создании пользователя произошла ошибка: $message",
            $code,
            $previous
        );
    }
}
