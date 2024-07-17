<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FormViewController extends Controller
{
    public function form(Request $request): Response
    {
        return response()->view("form");
    }

    public function submitForm(Request $request): Response
    {
        $name = $request->input('name');
        return response()->view('hello', ['name' => $name]);
    }
}
