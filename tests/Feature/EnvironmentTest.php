<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Env;
use Tests\TestCase;

class EnvironmentTest extends TestCase
{
    public function testGetEnv(): void
    {
        $youtube = env('YOUTUBE');
        self::assertEquals('Learn Laravel', $youtube);
    }

    public function testDefaultEnv(): void
    {
        $author = env("AUTHOR", "Johntakpor"); // working too
        $author = Env::get('AUTHOR','Johntakpor');
        
        self::assertEquals("Johntakpor", $author);
    }
}
