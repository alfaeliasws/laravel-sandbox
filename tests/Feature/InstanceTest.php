<?php

namespace Tests\Feature;

use App\Data\Person;
use Tests\TestCase;

class InstanceTest extends TestCase
{
  
  public function testInstance()
  {
    $person = new Person('Johntakpor', 'Songkali');
    $this->app->instance(Person::class,$person);

    $person1 = $this->app->make(Person::class);
    $person2 = $this->app->make(Person::class);

    self::assertEquals("Johntakpor", $person1->firstName);
    self::assertEquals("Johntakpor", $person2->firstName);
    self::assertSame($person, $person1);
    self::assertSame($person1, $person2);
    
  }
}

?>