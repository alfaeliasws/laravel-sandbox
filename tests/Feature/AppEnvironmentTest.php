<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class AppEnvironmentTest extends TestCase
{
    public function appEnv(): void
    {
        var_dump(App::environment());
    }

    public function testAssertAppEnv(): void
    {
        if(App::environment('testing')){
            self::assertTrue(true);
        }
    }
}