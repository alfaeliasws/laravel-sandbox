<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    
    public function testView()
    {
        $this->get('hello')
            ->assertSeeText('Hello hello');

        $this->get("hello-again")
            ->assertSeeText('Hello Johnson');
    }

    public function testViewNested()
    {
        $this->get('/hello-world')
            ->assertSeeText('Hello World');
    }

    public function testViewWithoutRoute()
    {
        $this->view('hello', [ "name" => "John" ])
            ->assertSeeText("Hello John");
    }

}
