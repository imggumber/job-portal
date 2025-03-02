<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // If the user is authenticated and trying to access login or register page, redirect to profile
        if (Auth::check() && ($request->is('account/login') || $request->is('account/register'))) {
            return Redirect::route('account.profile');
        }

        // If the user is not authenticated and trying to access any protected page, redirect to login
        if (!Auth::check() && !$request->is('account/login') && !$request->is('account/register')) {
            return Redirect::route('account.login')->with('error', 'Please login');
        }

        return $next($request);
    }
}
