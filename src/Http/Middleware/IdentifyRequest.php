<?php

declare(strict_types=1);

namespace Blumilk\BLT\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class IdentifyRequest
{
    public function handle(Request $request, Closure $next): Response
    {
        $request->attributes->set("id", (string)Str::uuid());
        return $next($request);
    }
}
