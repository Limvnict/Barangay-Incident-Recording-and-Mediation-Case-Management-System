<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class RoleMiddleware {
    public function handle(Request $request, Closure $next, string ...$roles) {
        if (! in_array($request->user()->role, $roles, true)) {
            abort(403, 'This page is not available for your role.');
        }
        return $next($request);
    }
}
