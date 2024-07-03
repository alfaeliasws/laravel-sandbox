<?php

namespace tests\Feature;

use App\Data\Person;
use Tests\TestCase;

class SingletonTest extends TestCase
{
  
  public function testSingleton()
  {
    $this->app->singleton(Person::class, function ($app) {
      return new Person('Johntakpor','Songkali');
    });

    $person1 = $this->app->make(Person::class);
    $person2 = $this->app->make(Person::class);

    self::assertEquals("Johntakpor", $person1->firstName);
    self::assertEquals('Johntakpor', $person2->firstName);
    self::assertSame($person1, $person2);
  }

}

?>