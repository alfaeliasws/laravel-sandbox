<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputTest extends TestCase
{

    public function testInput()
    {
        $this->get('/input/hello?name=Johnson')->assertSeeText("Hello Johnson");
        $this->post('/input/hello', ["name" => "Johnson"])->assertSeeText("Hello Johnson");
    }

    public function testInputNested()
    {
        $this->post('/input/hello/first', ["name" => [
            "first" => "Johnson",
            "last" => "Songkali"
        ]])->assertSeeText("Hello Johnson");
    }

    public function testInputGetAll()
    {
        $this->post('/input/hello/input', ["name" => [
            "first" => "Johnson",
            "last" => "Songkali"
        ]])->assertSeeText("name")->assertSeeText("first")->assertSeeText("Johnson")->assertSeeText("last")->assertSeeText("Songkali");
    } 

    public function testInputArray()
    {
        $this->post('/input/hello/array', ["products" => [
            [
                "name" => "Apple Mac Book Pro",
                "price" => "20000000"
            ],
            [
                "name" => "Samsung Galaxy S",
                "price" => "18000000"
            ]
        ]])->assertSeeText("Apple Mac Book Pro")->assertSeeText("Samsung Galaxy S");
    } 

    public function testInputType()
    {
        $this->post('input/type', [
            "name" => "Johntakpor",
            "married" => "true",
            "birth_date" => '1998-12-12'
        ])->assertSeeText("Budi")->assertSeeText("true")->assertSeeText('1998-12-12');
    }

    public function testFilterOnly()
    {
        $this->post('input/filter-only', [
            "name" => [
                "first" =>  "Johntakpor",
                "middle" => "Johnson",
                "last" => "Songkali"
            ]
        ])->assertSeeText("Johntakpor")->assertSeeText("Songkali")->assertDontSeeText("Johnson");
    }

    public function testFilterExcept()
    {
        $this->post('input/filter-except', [
            "username" => "Johnson",
            "admin" => "true",
            "password" => "rahasia" 
        ])->assertSeeText("Johnson")->assertSeeText("rahasia")->assertDontSeeText("admin");
    }

    public function testMerge()
    {
        $this->post('input/filter-merge', [
            "username" => "Johnson",
            "admin" => "true",
            "password" => "rahasia" 
        ])->assertSeeText("Johnson")->assertSeeText("rahasia")->assertSeeText("admin")->assertSeeText("false");
    }

}
