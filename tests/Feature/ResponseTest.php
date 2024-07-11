<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResponseTest extends TestCase
{

    public function testResponse()
    {
        $this->get('response/hello')
            ->assertStatus(200)
            ->assertSeeText("Hello Response");
    }

    public function testHeaderResponse()
    {
        $this->get('response/header')
            ->assertStatus(200)
            ->assertSeeText("Johnson")
            ->assertSeeText("Mike")
            ->assertHeader("Content-Type", "application/json")
            ->assertHeader("Author", "Andre Arshavin")
            ->assertHeader("App", "Laravel Relearning");
    }

    public function testView()
    {
        $this->get('response/type/view')
        ->assertSeeText('Hello Johnson');
    }


    public function testJson()
    {
        $this->get('response/type/json')
        ->assertJson(
            ['firstName' => 'Johntakpor', 'lastName' => 'Songkali']
        );
    }

    public function testFile()
    {
        $this->get('response/type/file')
            ->assertHeader('Content-Type', 'image/png');
    }

    public function testDownload()
    {
        $this->get('response/type/download')
            ->assertDownload('johnson.png');
    }
}
