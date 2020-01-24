<?php

namespace App\Http\Middleware;

use Closure;

class HakAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $rule)
    {
        if(auth()->check() && !auth()->user()->punyaRule($rule)){
            return redirect('pageError');
        }
        return $next($request);
    }
}
