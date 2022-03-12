<?php

namespace Rizkhal\Inertable;

use Closure;
use Illuminate\Support\Str;

class Column
{
    public string|null $column = null;

    public string|null $text = null;

    public bool $blank = false;

    public bool $sortable = false;

    public bool $searchable = false;

    public bool $checkbox = false;

    public Closure|null $sortCallback = null;

    public Closure|null $searchCallback = null;

    public Closure|null $formatCallback = null;

    public function __construct(string|null $text = null, string|null $column = null)
    {
        $this->text = $text;

        if (!$column && $text) {
            $this->column = Str::snake($text);
        } else {
            $this->column = $column;
        }

        if (!$this->column && !$this->text) {
            $this->blank = true;
        }
    }

    public static function make(string|null $text = null, string|null $column = null): Column
    {
        return new static($text, $column);
    }

    public static function blank(): Column
    {
        return new static(null, null);
    }

    public static function action($column = 'action'): Column
    {
        return new static($column, null);
    }

    public static function checkbox($column = 'checkbox'): Column
    {
        return new static($column, null);
    }

    public function text(): string|null
    {
        return $this->text;
    }

    public function sortable(callable|null $callback = null): self
    {
        $this->sortable = true;

        $this->sortCallback = $callback;

        return $this;
    }

    public function searchable(callable|null $searchCallback = null): Column
    {
        $this->searchable = true;

        $this->searchCallback = $searchCallback;

        return $this;
    }

    public function hasSearchCallback(): bool
    {
        return $this->searchCallback !== null;
    }

    public function getSearchCallback(): callable|null
    {
        return $this->searchCallback;
    }

    public function isSearchable(): bool
    {
        return $this->searchable === true;
    }

    public function isSortable(): bool
    {
        return $this->sortable === true;
    }

    public function hasSortCallback(): bool
    {
        return $this->sortCallback !== null;
    }

    public function getSortCallback(): callable|null
    {
        return $this->sortCallback;
    }

    public function format(callable $callable): Column
    {
        $this->formatCallback = $callable;

        return $this;
    }

    public function hasFormatCallback(): bool
    {
        return $this->formatCallback !== null;
    }

    public function getFormatCallback(): callable|null
    {
        return $this->formatCallback;
    }
}
