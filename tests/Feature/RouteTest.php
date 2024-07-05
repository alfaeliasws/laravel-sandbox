<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RouteTest extends TestCase
{
    public function testBasicRouting()
    {
        $this->get("/johntakpor")
            ->assertStatus(200)
            ->assertSeeText("Hello Johntakpor");
    }

    public function testRedirect()
    {
        $this->get("/youtube")
            ->assertRedirect("/johntakpor");
    }

    public function testFallback()
    {
        $this->get('/404')
            ->assertSeeText("404 this is fallback");
    
        $this->get('/nothing')
            ->assertSeeText("404 this is fallback");

        $this->get('/fallback')
            ->assertSeeText("404 this is fallback");
    }    
}
