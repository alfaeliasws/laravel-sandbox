<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CookieTest extends TestCase
{

    public function testCreateCookie()
    {
        $this->get('/cookies/set')
            ->assertCookie('User-Id', 'johntakpor')
            ->assertCookie('Is-Member', 'true');
    }

    public function testGetCookie()
    {
        $this->withCookie('User-Id', 'johntakpor')
            ->withCookie('Is-Member', 'true')
            ->get('/cookies/get')
            ->assertJson([
                'userId' => 'johntakpor',
                'isMember' => 'true'
            ]);
    }
}
