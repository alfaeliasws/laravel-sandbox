<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ControllerTest extends TestCase
{

    public function testHelloController()
    {
        $this->get("controller/hello")
            ->assertSeeText("Hello World");
    }

    public function testHelloController2()
    {
        $this->get("controller/hello2/Johnson")
            ->assertSeeText("Hello Johnson");
    }

    public function testHelloController3()
    {
        $this->get("controller/hello3/Johnson")
            ->assertSeeText("Hello Johnson");
    }

}
