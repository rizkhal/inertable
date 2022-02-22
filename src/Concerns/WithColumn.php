<?php

namespace Rizkhal\Inertable\Concerns;

interface WithColumn
{
    /**
     * Inertable columns
     *
     * @return array
     */
    public function columns(): array;
}
