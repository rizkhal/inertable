<?php

namespace Rizkhal\Inertable;

use Inertia\Inertia;
use Illuminate\Support\ServiceProvider;

class InertableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerCommands()->registerMacroable();
    }

    public function registerCommands(): self
    {
        $this->commands([
            \Rizkhal\Inertable\Commands\MakeInertableCommand::class,
        ]);

        return $this;
    }

    public function registerMacroable(): self
    {
        Inertia::macro('title', function ($title) {
            return $this->with('title', $title);
        });

        Inertia::macro('inertable', function ($table) {
            return $this->with([
                'inertable' => [
                    'fields' => $table->fields(),
                    'columns' => $table->columns(),
                    'data' => $table->applyInertable(request()),
                    'filters' => request()->all(['column', 'search', 'direction', 'filters', 'perpage']),
                ]
            ]);
        });

        return $this;
    }
}
