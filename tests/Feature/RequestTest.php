<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RequestTest extends TestCase
{
    public function testRequest()
    {
        $this->get('controller/request', [
            "Accept" => "plain/text"
        ])->assertSeeText('controller/request')
            ->assertSeeText("http://localhost/controller/request")
            ->assertSeeText('GET')
            ->assertSeeText('plain/text')
        ;
    }
}