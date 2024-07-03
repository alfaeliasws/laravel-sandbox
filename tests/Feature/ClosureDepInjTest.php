<?php 

namespace Tests\Feature;

use App\Data\Bar;
use App\Data\Foo;
use Tests\TestCase;

class ClosureDepInjTest extends TestCase
{
  public function testClosure()
  {
    
    $this->app->singleton(Foo::class, function($app){
      return new Foo();
    });

    $this->app->singleton(Bar::class, function($app){
      return new Bar($app->make(Foo::class));
    });

    $bar1 = $this->app->make(Bar::class);
    $bar2 = $this->app->make(Bar::class);
    
    self::assertSame($bar1, $bar2);
  }
}

?>