<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class urlTest extends TestCase
{

    public function testCurrent()
    {
        $this->get('/url/current?name=John')
            ->assertSeeText('/url/current?name=John');
    }

    public function testNamed()
    {
        $this->get('url/named')->assertSeeText('/redirect/name/Justin');
    }

    public function testAction()
    {
        $this->get('url/action')->assertSeeText('/form');
    }

}
