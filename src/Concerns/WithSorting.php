<?php

namespace Rizkhal\Inertable\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Rizkhal\Inertable\View\Column;

/**
 * With Sorting
 */
trait WithSorting
{
    public function hasSort(): bool
    {
        return request()->hasAny(['column', 'direction']);
    }

    public function getSortableColumns(): array
    {
        return array_filter($this->columns(), fn (Column $column): bool => $column->isSortable());
    }

    public function applySorting(Request $request, $query): Builder
    {
        $query->when($this->hasSort(), function (Builder $subQuery) use ($query, $request): void {
            foreach ($this->getSortableColumns() as $column) {
                if ($this->getColumn($column->column)->hasSortCallback()) {
                    if ($request->column === $column->column) {
                        $query = app()->call($this->getColumn($column->column)->getSortCallback(), ['query' => $query, 'direction' => $request->direction]);
                    }
                } else {
                    if ($request->column === $column->column) {
                        $subQuery->orderBy($column->column, $request->direction);
                    }
                }
            }
        });

        return $query;
    }
}
