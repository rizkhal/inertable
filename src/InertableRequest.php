<?php

namespace Rizkhal\Inertable;

use Rizkhal\Inertable\Column;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class InertableRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'direction' => Rule::in(['asc', 'desc']),
            'column' => Rule::in(collect($this->columns())->pluck('column')->all())
        ];
    }

    public function getSearchableColumns(): array
    {
        return array_filter($this->columns(), fn (Column $column) => $column->isSearchable());
    }
}
