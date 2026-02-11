<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken() ?? $request->header('X-API-Token') ?? $request->query('api_token');

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token de autenticação não fornecido.',
            ], 401);
        }

        $validToken = Setting::get('api_token', 'Popadic17');

        if (!hash_equals($validToken, $token)) {
            return response()->json([
                'success' => false,
                'message' => 'Token de autenticação inválido.',
            ], 401);
        }

        return $next($request);
    }
}
