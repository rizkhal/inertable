![Package Logo](https://banners.beyondco.de/INERTABLE.png?theme=light&packageManager=composer+require&packageName=rizkhal%2Finertable&pattern=jigsaw&style=style_1&description=A+Headles+datatable+for+Laravel+with+Inertia&md=1&showWatermark=0&fontSize=100px&images=table&widths=auto)

<p align="center">

<a href="https://github.com/rizkhal/inertable/actions/workflows/tests.yml/badge.svg">
<img alt="GitHub last commit" src="https://github.com/rizkhal/inertable/actions/workflows/tests.yml/badge.svg">
</a>

<a href="https://github.com/rizkhal/inertable/actions/workflows/php-cs-fixer.yml/badge.svg">
<img alt="GitHub cs fixer" src="https://github.com/rizkhal/inertable/actions/workflows/php-cs-fixer.yml/badge.svg">
</a>

<a href="https://img.shields.io/github/last-commit/rizkhal/inertable?style=plastic">
<img alt="GitHub last commit" src="https://img.shields.io/github/last-commit/rizkhal/inertable">
</a>

<a href="https://img.shields.io/github/issues/rizkhal/inertable">
<img alt="GitHub issues" src="https://img.shields.io/github/issues/rizkhal/inertable">
</a>
  
<a href="https://img.shields.io/packagist/v/rizkhal/inertable">
<img alt="Packagist Version" src="https://img.shields.io/packagist/v/rizkhal/inertable">
</a>

</p>

## INSTALATION

```bash
composer require rizkhal/inertable
```

## USAGE

```bash
php artisan make:inertable UserTable
```

```php
<?php

declare(strict_types=1);

namespace App\Inertable;

use App\Models\User;
use Rizkhal\Inertable\Column;
use Illuminate\Support\Carbon;
use Rizkhal\Inertable\Inertable;
use Illuminate\Database\Eloquent\Builder;

class UserTable extends Inertable
{
    public function query(): Builder
    {
        return User::query();
    }

    public function columns(): array
    {
        return [
            Column::checkbox(),
            Column::make(__('Name'), 'name')->sortable()->searchable(),
            Column::make(__('Email'), 'email')->sortable()->searchable(),
            Column::make(__('Verified'), 'email_verified_at')->sortable()->searchable()->format(fn (Carbon $value): string => $value->format('d/m/Y')),
            Column::make(__('status'), 'status')->sortable()->searchable(),
            Column::action(),
        ];
    }
}
```

Add hidden response

```php
protected $hiddens = [
    'office'
];
```

The response will include `office` object in response to inertable props.

Hidden response also accept relatoin, for example if you have `HasMany` relation from user to posts

```php
protected $hiddens = [
    'user.posts'
];
```

That's will return hidden user posts inside inertable props.
