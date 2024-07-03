<?php 

namespace Tests\Feature;

use App\Services\HelloService;
use App\Services\HelloServiceEnglish;
use Tests\TestCase;

class HelloServiceTest extends TestCase
{
  public function testHelloService()
  {
    $this->app->singleton(HelloService::class, HelloServiceEnglish::class);

    $helloService = $this->app->make(HelloService::class);

    self::assertEquals("Hello Johnson", $helloService->hello("Johnson"));
  }
}

?>