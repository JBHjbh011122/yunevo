<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class UserTypeMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            // Добавляем информацию о типе пользователя во все представления
            view()->share('userType', Auth::user()->user_type);
        }

        return $next($request);
    }
}
