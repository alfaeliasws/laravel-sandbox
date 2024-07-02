<?php

namespace Tests\Feature;

use App\Data\Foo;
use App\Data\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceContainerTest extends TestCase
{
    public function testCreateDependency()
    {
        $foo = $this->app->make(Foo::class);
        $foo2 = $this->app->make(Foo::class);

        self::assertEquals("Foo", $foo->foo());
        self::assertEquals("Foo", $foo->foo());
        self::assertNotSame($foo, $foo2);
    }

    public function testBind(){
        
        $this->app->bind(Person::class, function($app){
            return new Person("Johntakpor", "Songkali");
        });

        $person1 = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class);

        self::assertEquals("Johntakpor", $person1->firstName);
        self::assertEquals("Johntakpor", $person2->firstName );
        self::assertNotSame($person1, $person2);
    }
}
