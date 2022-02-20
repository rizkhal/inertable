<?php

declare(strict_types=1);

namespace Rizkhal\Inertable\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeInertableCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:inertable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Inertable class';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/inertable.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Inertable';
    }
}
