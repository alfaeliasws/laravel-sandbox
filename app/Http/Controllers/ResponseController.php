<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResponseController extends Controller
{

    public function response(Request $request): Response
    {
        return response("Hello Response");
    }

    public function headerResponse(Request $request): Response
    {
        $body = [
            'firstName' => 'Johnson', 'lastName' => 'Mike',
        ];

        return response(json_encode($body), 200)
            ->header('Content-Type', 'application/json')
            ->withHeaders([
                'Author' => 'Andre Arshavin',
                'App' => 'Laravel Relearning',
            ]);
    }
    
    public function responseView(Request $request): Response
    {
        return response()
            ->view('hello', ['name' => 'Johnson']);
    }

    public function responseJson(Request $request): JsonResponse
    {
        $body = ['firstName' => 'Johntakpor', 'lastName' => 'Songkali'];
        return response()->json($body);
    }

    public function responseFile(Request $request): BinaryFileResponse
    {
        return response()->file(storage_path('app/public/pictures/johnson.png'));
    }

    public function responseDownload(Request $request): BinaryFileResponse
    {
        return response()->download(storage_path('app/public/pictures/johnson.png'), 'johnson.png');
    }

}
