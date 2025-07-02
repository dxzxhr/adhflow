<?php

namespace App\Http\Middleware;

use Closure;

class EnsureTwoFactorEnabled
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if ($user && is_null($user->two_factor_secret)) {
            return redirect()->route('twofactor.prompt');
        }

        return $next($request);
    }
}
