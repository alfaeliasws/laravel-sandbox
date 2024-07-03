<?php 

namespace App\Services;

class HelloServiceEnglish implements HelloService
{
  public function hello(string $name): string
  {
    return "Hello $name";
  }
}

?>