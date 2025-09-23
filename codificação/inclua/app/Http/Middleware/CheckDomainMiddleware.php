<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckDomainMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $allowedHost = env('ALLOWED_HOST');
        $requestHost = parse_url($request->headers->get('referer'), PHP_URL_HOST) ?? $request->getHost();

        if ($requestHost !== $allowedHost) {
            abort(403, 'Acesso não autorizado.');
        }

        return $next($request);
    }
}
