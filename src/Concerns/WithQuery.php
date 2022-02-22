<?php

namespace Rizkhal\Inertable\Concerns;

use Illuminate\Database\Eloquent\Builder;

interface WithQuery
{
    /**
     * Inertable query
     *
     * @return Builder
     */
    public function query(): Builder;
}