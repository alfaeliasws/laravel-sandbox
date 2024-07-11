<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StorageTest extends TestCase
{
    public function testStorage()
    {
        $filesystem = Storage::disk("local");
        $filesystem->put("file.txt", "Put Your Control Here");

        self::assertEquals("Put Your Control Here", $filesystem->get("file.txt"));
    }

    public function testPublic()
    {
        $filesystem = Storage::disk("public");
        $filesystem->put("file.txt", "Put Your Control Here");

        self::assertEquals("Put Your Control Here", $filesystem->get("file.txt"));
    }

}
