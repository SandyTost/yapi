<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Проверка на администратора
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Проверяем, является ли пользователь администратором
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Если пользователь не администратор, возвращаем 404
        return abort(404);
    }
}
