<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class FileTest extends TestCase
{

    public function testUpload()
    {
        $image = UploadedFile::fake()->image("johnson.png");
        $this->post('file/upload', [
            "picture" => $image
        ])->assertSeeText("OK : johnson.png");
    }

}
