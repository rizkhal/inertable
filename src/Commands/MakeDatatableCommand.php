<?php

declare(strict_types=1);

namespace Rizkhal\Datatable\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeDatatableCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:datatable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Datatable class';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/datatable.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Datatable';
    }
}
