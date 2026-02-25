<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiLogMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);

        // Log da request
        Log::channel('api')->info('API Request', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => substr($request->userAgent() ?? 'unknown', 0, 100),
            'body_size' => strlen($request->getContent()),
            'has_files' => $request->allFiles() ? count($request->allFiles()) : 0,
        ]);

        try {
            $response = $next($request);
        } catch (\Throwable $e) {
            $duration = round((microtime(true) - $startTime) * 1000);

            Log::channel('api')->error('API Exception', [
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile() . ':' . $e->getLine(),
                'duration_ms' => $duration,
            ]);

            throw $e;
        }

        $duration = round((microtime(true) - $startTime) * 1000);

        // Log da response
        $logMethod = $response->getStatusCode() >= 400 ? 'warning' : 'info';
        Log::channel('api')->$logMethod('API Response', [
            'method' => $request->method(),
            'url' => $request->path(),
            'status' => $response->getStatusCode(),
            'duration_ms' => $duration,
            'ip' => $request->ip(),
            'response_size' => strlen($response->getContent()),
        ]);

        // Se erro, logar detalhes da resposta
        if ($response->getStatusCode() >= 400) {
            $body = json_decode($response->getContent(), true);
            Log::channel('api')->warning('API Error Detail', [
                'url' => $request->fullUrl(),
                'status' => $response->getStatusCode(),
                'response' => is_array($body) ? $body : substr($response->getContent(), 0, 500),
            ]);
        }

        return $response;
    }
}
