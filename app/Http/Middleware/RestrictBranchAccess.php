<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictBranchAccess
{
    private array $exact = [
        'admin.dashboard',
        'logout',
    ];

    private array $prefixes = [
        'admin.gallery.',
        'admin.pastors.',
        'admin.locations.',
        'admin.account.',
    ];

    private array $blockedExact = [
        'admin.pastors.create',
        'admin.pastors.store',
        'admin.pastors.destroy',
        'admin.locations.create',
        'admin.locations.store',
        'admin.locations.destroy',
        'admin.account.branding',
        'content.dashboard.pastors.create',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || ! $user->isBranch()) {
            return $next($request);
        }

        $routeName = $request->route()?->getName() ?? '';

        if (in_array($routeName, $this->blockedExact, true)) {
            abort(403, 'Your branch account cannot perform this action.');
        }

        if (in_array($routeName, $this->exact, true)) {
            return $next($request);
        }

        foreach ($this->prefixes as $prefix) {
            if (str_starts_with($routeName, $prefix)) {
                return $next($request);
            }
        }

        abort(403, 'Your branch account cannot access this area.');
    }
}
