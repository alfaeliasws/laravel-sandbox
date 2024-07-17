<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ExampleParamMiddleware
{
    public function handle(Request $request, Closure $next, string $key, int $status ){
        $apiKey = $request->header('X-API-KEY');
        if($apiKey == $key){
            return $next($request);
        } else {
            return response('Access Denied', $status);
        }
    }
}
