<?php

namespace Rizkhal\Inertable;

use Illuminate\Support\ServiceProvider;
use Inertia\Response as InertiaResponse;

class InertableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerCommands();
        $this->registerMacroable();
    }

    protected function registerCommands(): void
    {
        $this->commands([
            \Rizkhal\Inertable\Commands\MakeInertableCommand::class,
        ]);
    }

    protected function registerMacroable(): void
    {
        InertiaResponse::macro('inertable', function (Inertable $table) {
            return $this->with([
                $table->getTableName() => [
                    'fields' => $table->fields(),
                    'columns' => $table->columns(),
                    'data' => $table->applyInertable(request()),
                    'filters' => request()->all(['column', 'search', 'direction', 'filters', 'perpage']),
                ],
            ]);
        });
    }
}
