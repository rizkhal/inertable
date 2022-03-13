<?php

namespace Rizkhal\Inertable;

use Illuminate\Http\Request;
use Rizkhal\Inertable\Column;
use Illuminate\Database\Eloquent\Model;
use Rizkhal\Inertable\Concerns\WithQuery;
use Rizkhal\Inertable\Concerns\WithColumn;
use Rizkhal\Inertable\Concerns\WithFilter;
use Rizkhal\Inertable\Concerns\WithPerPage;
use Rizkhal\Inertable\Concerns\WithSorting;
use Rizkhal\Inertable\Utils\ColumnAttributes;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class Inertable implements WithQuery, WithColumn
{
    use WithFilter,
        WithPerPage,
        WithSorting;

    public function columnsMerged(): array
    {
        if (method_exists($this, 'getKey')) {
            return array_merge([Column::make($this->getKey())], $this->columns());
        }

        return array_merge([Column::make('id')], $this->columns());
    }

    /**
     * Get searhable columns
     *
     * @return array
     */
    public function getSearchableColumns(): array
    {
        return array_filter($this->columnsMerged(), fn (Column $column): bool => $column->isSearchable());
    }

    /**
     * Get column
     *
     * @param string|null $column
     * @return \Illuminate\Support\TValue|\Illuminate\Support\TFirstDefault
     */
    public function getColumn(string|null $column): object
    {
        return collect($this->columnsMerged())->where('column', $column)->first();
    }

    /**
     * Datatable
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function applyInertable(Request $request): LengthAwarePaginator
    {
        $query = $this->query();

        $query = $this->applySorting($request, $query);

        $query = $this->applySearchFilter($request, $query);

        return $query->paginate($this->perPage())->withQueryString()->through(fn ($model) => $this->through($model));
    }

    /**
     * Through
     *
     * @param Model $model
     * @return array
     */
    private function through(Model $model): array
    {
        $items = [];

        foreach ($this->columnsMerged() as $column) {
            if (ColumnAttributes::hasRelation($column->column)) {
                if (ColumnAttributes::hasMultipleRelation($column->column)) {
                    if ($this->getColumn($column->column)->hasFormatCallback()) {
                        $items[$column->column] = app()->call($this->getColumn($column->column)->getFormatCallback(), ['value' => $model->{$column->column}, 'row' => $model]);
                    } else {
                        [$relationName_1, $relationName_2, $relationAttribute_1] = explode('.', $column->column);
                        $items[$column->column] = $model->{$relationName_1}?->{$relationName_2}?->{$relationAttribute_1};
                    }
                } else {
                    if ($this->getColumn($column->column)->hasFormatCallback()) {
                        $items[$column->column] = app()->call($this->getColumn($column->column)->getFormatCallback(), ['value' => $model->{$column->column}, 'row' => $model]);
                    } else {
                        [$relationName, $relationAttribute] = explode('.', $column->column);
                        $items[$column->column] = $model->{$relationName}?->{$relationAttribute};
                    }
                }
            } else {
                if ($this->getColumn($column->column)->hasFormatCallback()) {
                    $items[$column->column] = app()->call($this->getColumn($column->column)->getFormatCallback(), ['value' => $model->{$column->column}, 'row' => $model]);
                } else {
                    $items[$column->column] = $model->{$column->column};
                }
            }
        }

        return $items;
    }
}
