<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class configTest extends TestCase
{
    public function testConfig(): void
    {
        $firstName = config("contoh.author.first");
        $lastName = config("contoh.author.last");
        $email = config("contoh.email");
        $web = config("contoh.web");

        self::assertEquals("Johntakpor", $firstName);
        self::assertEquals("Songkali", $lastName);
        self::assertEquals("johntakporsongkali@gmail.com", $email);
        self::assertEquals("alfaelias.netlify.app", $web);
    }
}
