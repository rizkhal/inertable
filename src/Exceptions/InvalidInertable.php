<?php

namespace Rizkhal\Inertable\Exceptions;

use InvalidArgumentException;

class InvalidInertable extends InvalidArgumentException
{
    public static function create(): static
    {
        return new static("The given inertable is invalid.");
    }
}
