<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleExceptions
{
    public function handle(Request $request, Closure $next): Response
    {
        $ignoredRoutes = ['checkPaymentStatus'];
        $response = $next($request);
        if (env('PRODUCAO')) {
            $currentMethod = optional($request->route())->getActionMethod();
          if (in_array($currentMethod, $ignoredRoutes)) {
              return $response;
          }


        // Verifica se a resposta é um erro (400-599)
        if ($response->isClientError() || $response->isServerError()) {
        //    dd(Response::$statusTexts[$response->getStatusCode()]);
            return redirect()->route('error.page')->with([
                'error_code' => $response->getStatusCode(),
                'error_message' => Response::$statusTexts[$response->getStatusCode()] ?? 'Erro desconhecido'
            ]);
        }
        }

        return $response;
    }

    public function render($request, Throwable $exception)
    {
        // Captura todas as exceções não tratadas
        return redirect()->route('error.page')->with([
            'error_code' => method_exists($exception, 'getStatusCode')
                ? $exception->getStatusCode()
                : 500,
            'error_message' => $exception->getMessage() ?: 'Erro interno do servidor'
        ]);
    }
}
