<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\VisitorLog;
class LogVisitorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function handle(Request $request, Closure $next)
    {
        // Jangan catat jika request ke route admin
        if (!$request->is('admin/*')) {
            VisitorLog::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent')
            ]);
        }
        return $next($request);
    }
}