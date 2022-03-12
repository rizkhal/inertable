<?php

namespace Rizkhal\Inertable\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Rizkhal\Inertable\InertableServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected function setUp(): void
    {
        # code...
    }

    protected function getPackageProviders($app)
    {
        return [InertableServiceProvider::class];
    }
}
