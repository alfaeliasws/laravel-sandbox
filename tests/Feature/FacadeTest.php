<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class FacadeTest extends TestCase
{

    public function testConfig(){
        $firstname = config("contoh.author.first");
        $firstname2 = Config::get("contoh.author.first");

        self::assertEquals($firstname, $firstname2);
        
        var_dump(Config::all());
    }

    public function testConfigDependency()
    {
        $config = $this->app->make("config");

        //different way to call config
        $firstName = $config->get("contoh.author.first");
        $firstName2 = Config::get('contoh.author.first');
        $firstName3 = config("contoh.author.first");

        self::assertEquals($firstName, $firstName2);
        self::assertEquals($firstName, $firstName3);
        self::assertEquals($firstName2, $firstName3);


        var_dump(Config::all());
    }

    public function testConfigMock()
    {
        
        //It is mock data that can be used
        Config::shouldReceive('get')
            ->with("contoh.author.first")
            ->andReturn("Mike Mozawski");

        $firstName = Config::get("contoh.author.first");

        self::assertEquals("Mike Mozawski", $firstName);

    }

}
