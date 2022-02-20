<?php

namespace Rizkhal\Inertable\Concerns;

/**
 * With Append
 */
trait WithAppend
{
    public function appends(): array
    {
        return [];
    }

    public function hasAppends(): bool
    {
        return count($this->appends()) > 0 ? true : false;
    }
}
