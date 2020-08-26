<?php

namespace App\Http\Middleware;

use Closure;

class FoodbankMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::user()->isFoodbank == 1) {
          return $next($request);
        }
    
        return redirect()->route('landing');
    }
}
