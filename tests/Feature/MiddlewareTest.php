<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{
    public function testInvalid()
    {
        $this->get('middleware/api')
            ->assertStatus(401)
            ->assertSeeText("Access Denied");
    }

    public function testValid()
    {
        $this->withHeader('X-API-KEY', 'John')
            ->get('middleware/api')
            ->assertStatus(200)
            ->assertSeeText("OK");
    }

    public function testInvalidMiddlewareGroup()
    {
        $this->get('middleware/group')
            ->assertStatus(401)
            ->assertSeeText("Access Denied");
    }

    public function testValidMiddlewareGroup()
    {
        $this->withHeader('X-API-KEY', 'John')
            ->get('middleware/group')
            ->assertStatus(200)
            ->assertSeeText("GROUP");
    }

    
    public function testInvalidMiddlewareGroupParam()
    {
        $this->get('middleware/group2')
            ->assertStatus(401)
            ->assertSeeText("Access Denied");
    }

    public function testValidMiddlewareGroupParam()
    {
        $this->withHeader('X-API-KEY', 'john')
            ->get('middleware/group2')
            ->assertStatus(200)
            ->assertSeeText("GROUP");
    }

    public function testInvalidMiddlewareGroupRoute()
    {
        $this->get('middleware/api3')
            ->assertStatus(401)
            ->assertSeeText("Access Denied");
    }

    public function testValidMiddleGroupRoute()
    {
        $this->withHeader('X-API-KEY', 'john')
            ->get('middleware/api3')
            ->assertStatus(200)
            ->assertSeeText("OK");
    }


}
