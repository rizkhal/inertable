![Package Logo](https://banners.beyondco.de/INERTABLE.png?theme=light&packageManager=composer+require&packageName=rizkhal%2Finertable&pattern=jigsaw&style=style_1&description=A+Simple+Datatable+For+Laravel+Using+Inertia3+%26+Vue3&md=1&showWatermark=0&fontSize=100px&images=table&widths=auto)

<p align="center">

<a href="https://github.com/rizkhal/inertable/actions/workflows/tests.yml/badge.svg">
<img alt="GitHub last commit" src="https://github.com/rizkhal/inertable/actions/workflows/tests.yml/badge.svg">
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

<a href="https://img.shields.io/npm/v/@rizkhal/inertable-vue">
<img alt="Npm Version" src="https://img.shields.io/npm/v/@rizkhal/inertable-vue">
</a>

</p>

## SERVER SIDE INSTALATION

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

## CLIENT SIDE INSTALLATION

Using NPM

```bash
npm install @rizkhal/inertable-vue
```

Or YARN

```bash
yarn add @rizkhal/inertable-vue
```

Setup in `app.js`

```js
import inertable from "@rizkhal/inertable-vue";

// ...
app.use(inertable);
```

Usage in component or page

```vue
<template>
  <div class="mx-auto max-w-7xl py-10 px-5">
    <v-inertable :inertable="props.inertable" :actions="actions" @onAdd="handleOnAdd">
      <template #action>
        <button class="rounded bg-red-500 py-1 px-2 text-white focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Delete</button>
      </template>
    </v-inertable>
  </div>
</template>
<script setup>
import actions from "./actions.json";

const props = defineProps({
  inertable: Object,
});

const handleOnAdd = () => {
  console.log("on add triggered");
};
</script>
```

The `actions.json` just a simple array of object to generate button for handle your modal button to add data or something else

```json
[
  {
    "text": "New User",
    "icon": "PlusSmIcon",
    "emit": "onAdd"
  }
]
```

You can also using `slots` to make it

```vue
<v-inertable :inertable="props.inertable">
    <template #actions>
        <!-- add your buttons here -->
    </template>
</v-inertable>
```
