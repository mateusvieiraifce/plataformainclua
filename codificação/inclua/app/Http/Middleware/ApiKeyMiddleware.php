<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiKeyMiddleware
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
        $apiKey = $request->header('X-API-KEY') ?? $request->query('api_key');
         if (!$apiKey) {
            return response()->json([
                'error' => 'API KEY não fornecida',
                'message' => 'Forneça uma API KEY válida no header X-API-KEY ou no parâmetro api_key'
            ], Response::HTTP_UNAUTHORIZED);
        }

         if ($apiKey != env('API_INCUA_KEY')) {
             return response()->json([
                 'error' => 'API KEY não fornecida',
                 'message' => 'Forneça uma API KEY válida no header X-API-KEY ou no parâmetro api_key'
             ], Response::HTTP_UNAUTHORIZED);
         }
        return $next($request);
    }
}
