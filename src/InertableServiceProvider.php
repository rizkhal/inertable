<?php

namespace Rizkhal\Inertable;

use Rizkhal\Inertable\Inertable;
use Inertia\Response as Inertia;
use Illuminate\Support\ServiceProvider;

class InertableServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/inertable.php', 'inertable');
    }

    public function boot()
    {
        $this->registerCommands();
        $this->registerMacroable();
    }

    public function configurePublishing()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../config/inertable.php' => config_path('inertable.php'),
        ], 'inertable-config');
    }

    protected function registerCommands(): void
    {
        $this->commands([
            \Rizkhal\Inertable\Commands\MakeInertableCommand::class,
        ]);
    }

    protected function registerMacroable(): void
    {
        Inertia::macro('title', function ($title) {
            return $this->with('title', $title);
        });

        Inertia::macro('inertable', function (Inertable $table) {
            return $this->with([
                'inertable' => [
                    'fields' => $table->fields(),
                    'columns' => $table->columns(),
                    'data' => $table->applyInertable(request()),
                    'filters' => request()->all(['column', 'search', 'direction', 'filters', 'perpage']),
                ]
            ]);
        });
    }
}
