<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!($request->user()->user_type == 'A' ?? false)) {
            return $request->expectsJson()
                ? abort(403, 'You are not an administrator.')
                : redirect()->route('root')
                    ->with('alert-msg', 'You are not an administrator.')
                    ->with('alert-type', 'danger');;
        }
        return $next($request);
    }
}
