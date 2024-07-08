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
    
    public function testRouteParameter()
    {
        $this->get('products/1')
            ->assertSeeText('products : 1');

        $this->get('products/2')
            ->assertSeeText('products : 2');

        $this->get('products/1/items/XXX')
            ->assertSeeText('Products : 1, Items : XXX');

    }

    public function testRouteParamRegex()
    {
        $this->get('categories/1234')
            ->assertSeeText("Categories : 1234");

        $this->get("categories/salah")
            ->assertSeeText("404");
    }

    public function testOptionalParam()
    {
        
        $this->get('/users/1234')
            ->assertSeeText("Users : 1234");

        $this->get('/users/')
            ->assertSeeText("Users : 404")
        ;

    }

    public function testConflict()
    {
        $this->get('/conflict/budi')
            ->assertSeeText("Conflict budi");

        $this->get('/conflict/johntakpor')
            ->assertSeeText("Conflict with Johntakpor");
    }

}
