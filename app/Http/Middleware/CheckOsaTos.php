<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckOsaTos
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $authUser = Auth::user();

            if (empty($authUser->osa) === true) {
                return view('osa', [
                    'showform' => true,
                    'greeting' => $authUser->getGreetingArray(),
                    'redirect' => $request->fullUrl(),
                ]);
            }

            if (empty($authUser->tos) === true) {
                return view('terms', ['redirect' => $request->fullUrl()]);
            }
        }

        return $next($request);
    }
}
