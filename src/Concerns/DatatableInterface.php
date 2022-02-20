<?php

namespace Rizkhal\Inertable\Concerns;

use Illuminate\Database\Eloquent\Builder;

interface DatatableInterface
{
    /**
     * Datatable query
     *
     * @return Builder
     */
    public function query(): Builder;

    /**
     * Datatable columns
     *
     * @return array
     */
    public function columns(): array;
}
