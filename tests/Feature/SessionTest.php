<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionTest extends TestCase
{

    public function testCreateSession()
    {
        $this->get('/session/create')
            ->assertSeeText("OK")
            ->assertSessionHas("userId", "johntakpor")
            ->assertSessionHas("isMember", "true");
    }

    public function testGetSession()
    {
        $this->withSession([
            'userId' => 'johntakpor',
            'isMember' => 'true',
        ])->get('/session/get')
        ->assertSeeText("johntakpor")->assertSeeText("true");
    }
    
    public function testGetSessionFalse()
    {
        
        $this->withSession([])->get('/session/get')
        ->assertSeeText("guest")->assertSeeText("false");
    }

}
