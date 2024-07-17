<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ExampleMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');
        if($apiKey == "John"){
            return $next($request);
        } else {
            return response('Access Denied', 401);
        }
    }
}
