<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isSuperAdmin()) {
            if ($request->expectsJson()) {
                abort(403, 'Only headquarters admins can access this area.');
            }

            return redirect()
                ->route('admin.dashboard')
                ->with('denied', 'Only headquarters admins can access this area.');
        }

        return $next($request);
    }
}
