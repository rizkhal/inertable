<?php

namespace Rizkhal\Inertable\Concerns;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Datatable\Utils\Column as ColumnUtils;

/**
 * With Filter
 */
trait WithFilter
{
    public function fields(): array
    {
        return [];
    }

    public function applySearchFilter(Request $request, $query): Builder
    {
        $searchableColumns = $this->getSearchableColumns();

        $query->when($request->has('search') && count($searchableColumns), function (Builder $subQuery) use ($query, $request, $searchableColumns): void {
            $search = $request->get('search');

            // Group search conditions together
            $subQuery->where(function (Builder $subSubQuery) use ($search, $query, $searchableColumns) {
                foreach ($searchableColumns as $column) {
                    // Does this column have an alias or relation?
                    $hasRelation = ColumnUtils::hasRelation($column->column);

                    // Let's try to map this column to a selected column
                    $selectedColumn = ColumnUtils::mapToSelected($column->column, $query);

                    // If the column has a search callback, just use that
                    if ($column->hasSearchCallback()) {
                        // Call the callback
                        ($column->getSearchCallback())($subSubQuery, $search);
                    } elseif (!$hasRelation || $selectedColumn) { // If the column isn't a relation or if it was previously selected
                        $whereColumn = $selectedColumn ?? $column->column;

                        // TODO: Skip Aggregates
                        if (!$hasRelation) {
                            $whereColumn = $query->getModel()->getTable() . '.' . $whereColumn;
                        }

                        // We can use a simple where clause
                        $subSubQuery->orWhere($whereColumn, 'like', '%' . $search . '%');
                    } else {
                        if (ColumnUtils::hasMultipleRelation($column->column)) {
                            [$relationName_1, $relationName_2, $relationAttribute_1] = explode('.', $column->column);

                            $subSubQuery->orWhereHas($relationName_1 . '.' . $relationName_2, function (Builder $hasQuery) use ($relationAttribute_1, $search) {
                                $hasQuery->where($relationAttribute_1, 'LIKE', "%{$search}%");
                            });
                        } else {
                            // Parse the column
                            $relationName = ColumnUtils::parseRelation($column->column);
                            $fieldName = ColumnUtils::parseField($column->column);

                            // We use whereHas which can work with unselected relations
                            $subSubQuery->orWhereHas($relationName, function (Builder $hasQuery) use ($fieldName, $search) {
                                $hasQuery->where($fieldName, 'like', '%' . $search . '%');
                            });
                        }
                    }
                }
            });
        });

        return $query;
    }

    private function hasRequest(string $filter): bool
    {
        return request()->has("filters.$filter");
    }

    private function getRequest(string $filter): string|null
    {
        return request()->get('filters')[$filter];
    }

    public function hasFilter(string $filter): bool
    {
        return $this->hasRequest($filter) && $this->getRequest($filter) !== null && $this->getRequest($filter) !== '';
    }

    public function getFilter(string $filter): string|null
    {
        if ($this->hasFilter($filter)) {
            if (in_array($filter, collect($this->fields())->keys()->toArray(), true) && $this->fields()[$filter]->isSelect()) {
                return trim($this->getRequest($filter));
            }

            if (is_string($this->getRequest($filter))) {
                return trim($this->getRequest($filter));
            }

            return $this->getRequest($filter);
        }

        return null;
    }
}
