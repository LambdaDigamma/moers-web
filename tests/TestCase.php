<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    protected $baseUrl = 'http://localhost';

    public function setUp(): void
    {
        parent::setUp();
//        Artisan::call('migrate');
    }

    protected function tearDown(): void
    {
//        Artisan::call('migrate:reset');
        parent::tearDown();
    }

    use CreatesApplication;
}
