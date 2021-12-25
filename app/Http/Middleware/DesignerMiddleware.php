<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DesignerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth('designer')->check())
            return $next($request);

        return response()->json([
            'message' => 'You must be logged in.'
        ]);
    }
}
