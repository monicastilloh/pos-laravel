<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

public function handle($request, Closure $next)
{
    if (
        auth()->check() &&
        auth()->user()->must_change_password &&
        ! $request->is('password/change')
    ) {
        return redirect('/password/change');
    }

    return $next($request);
}

