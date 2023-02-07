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
<img alt="Packagist Version" src="https://img.shields.io/packagist/v/rizkhal/inertable?color=emerald">
</a>

<a href="https://img.shields.io/packagist/dd/rizkhal/inertable?color=emerald">
<img alt="Packagist Downloads" src="https://img.shields.io/packagist/dd/rizkhal/inertable?color=emerald">
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

## Usage inside controller

You can use this with reactjs, svelte or vue with inertajs

```php
public function __invoke() {
    return inertia('/path/to/file.{vue|jsx|svelte}')->inertable(new UserTable());
}
```

Response example

<details>
    <summary>Click view</summary>

```json
{
  "columns": [
    {
      "na": false,
      "blank": false,
      "sortable": true,
      "searchable": true,
      "checkbox": false,
      "sortCallback": null,
      "searchCallback": null,
      "formatCallback": null,
      "text": "name",
      "column": "name"
    },
    {
      "na": false,
      "blank": false,
      "sortable": true,
      "searchable": true,
      "checkbox": false,
      "sortCallback": null,
      "searchCallback": null,
      "formatCallback": null,
      "text": "email",
      "column": "email"
    },
    {
      "na": false,
      "blank": false,
      "sortable": true,
      "searchable": false,
      "checkbox": false,
      "sortCallback": null,
      "searchCallback": null,
      "formatCallback": {},
      "text": "email_verified_at",
      "column": "email_verified_at"
    },
    {
      "na": false,
      "blank": false,
      "sortable": true,
      "searchable": false,
      "checkbox": false,
      "sortCallback": null,
      "searchCallback": null,
      "formatCallback": {},
      "text": "created_at",
      "column": "created_at"
    }
  ],
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "name": "Robbie Abernathy",
        "email": "nyundt@example.com",
        "email_verified_at": "18/10/2022",
        "created_at": "18/10/2022"
      },
      {
        "id": 2,
        "name": "Alfredo Langworth",
        "email": "sofia.krajcik@example.com",
        "email_verified_at": "18/10/2022",
        "created_at": "18/10/2022"
      },
      {
        "id": 3,
        "name": "Deron Carroll",
        "email": "considine.jevon@example.net",
        "email_verified_at": "18/10/2022",
        "created_at": "18/10/2022"
      },
      {
        "id": 4,
        "name": "Mr. Geoffrey Ritchie Sr.",
        "email": "baumbach.alysha@example.net",
        "email_verified_at": "18/10/2022",
        "created_at": "18/10/2022"
      },
      {
        "id": 5,
        "name": "Miss Beth Kirlin IV",
        "email": "mauricio.abernathy@example.net",
        "email_verified_at": "18/10/2022",
        "created_at": "18/10/2022"
      },
      {
        "id": 6,
        "name": "Davon Huel MD",
        "email": "orland78@example.net",
        "email_verified_at": "18/10/2022",
        "created_at": "18/10/2022"
      },
      {
        "id": 7,
        "name": "Colleen Welch",
        "email": "mertz.chad@example.com",
        "email_verified_at": "18/10/2022",
        "created_at": "18/10/2022"
      },
      {
        "id": 8,
        "name": "Alvah Crona",
        "email": "albert78@example.org",
        "email_verified_at": "18/10/2022",
        "created_at": "18/10/2022"
      },
      {
        "id": 9,
        "name": "Verlie Streich",
        "email": "lubowitz.mckayla@example.com",
        "email_verified_at": "18/10/2022",
        "created_at": "18/10/2022"
      },
      {
        "id": 10,
        "name": "Ms. Kristy Yost",
        "email": "sauer.justina@example.org",
        "email_verified_at": "18/10/2022",
        "created_at": "18/10/2022"
      },
      {
        "id": 11,
        "name": "Jazmyn Blick",
        "email": "corkery.nella@example.net",
        "email_verified_at": "18/10/2022",
        "created_at": "18/10/2022"
      },
      {
        "id": 12,
        "name": "Dr. Hyman Hauck",
        "email": "tvonrueden@example.net",
        "email_verified_at": "18/10/2022",
        "created_at": "18/10/2022"
      },
      {
        "id": 13,
        "name": "Miss Heather Ernser DDS",
        "email": "kozey.dana@example.com",
        "email_verified_at": "18/10/2022",
        "created_at": "18/10/2022"
      },
      {
        "id": 14,
        "name": "Jovan Kiehn Jr.",
        "email": "bette.barton@example.org",
        "email_verified_at": "18/10/2022",
        "created_at": "18/10/2022"
      },
      {
        "id": 15,
        "name": "Mr. Florencio Huel",
        "email": "greynolds@example.com",
        "email_verified_at": "18/10/2022",
        "created_at": "18/10/2022"
      }
    ],
    "first_page_url": "http://example.test/users?page=1",
    "from": 1,
    "last_page": 134,
    "last_page_url": "http://example.test/users?page=134",
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "active": false
      },
      {
        "url": "http://example.test/users?page=1",
        "label": "1",
        "active": true
      },
      {
        "url": "http://example.test/users?page=2",
        "label": "2",
        "active": false
      },
      {
        "url": "http://example.test/users?page=3",
        "label": "3",
        "active": false
      },
      {
        "url": "http://example.test/users?page=4",
        "label": "4",
        "active": false
      },
      {
        "url": "http://example.test/users?page=5",
        "label": "5",
        "active": false
      },
      {
        "url": "http://example.test/users?page=6",
        "label": "6",
        "active": false
      },
      {
        "url": "http://example.test/users?page=7",
        "label": "7",
        "active": false
      },
      {
        "url": "http://example.test/users?page=8",
        "label": "8",
        "active": false
      },
      {
        "url": "http://example.test/users?page=9",
        "label": "9",
        "active": false
      },
      {
        "url": "http://example.test/users?page=10",
        "label": "10",
        "active": false
      },
      {
        "url": null,
        "label": "...",
        "active": false
      },
      {
        "url": "http://example.test/users?page=133",
        "label": "133",
        "active": false
      },
      {
        "url": "http://example.test/users?page=134",
        "label": "134",
        "active": false
      },
      {
        "url": "http://example.test/users?page=2",
        "label": "Next &raquo;",
        "active": false
      }
    ],
    "next_page_url": "http://example.test/users?page=2",
    "path": "http://example.test/users",
    "per_page": 15,
    "prev_page_url": null,
    "to": 15,
    "total": 2000
  },
  "filters": {
    "column": null,
    "search": null,
    "direction": null,
    "filters": null,
    "perpage": null
  }
}
```

</details>
