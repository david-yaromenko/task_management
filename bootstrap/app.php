<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;

return Application::configure(basePath: dirname(__DIR__))
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class
        ]);
    })
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->expectsJson()) {
                if ($e->getPrevious() instanceof ModelNotFoundException) {
                    return response()->json([
                        'message' => 'Resource not found.',
                        'errors' => [
                            'id' => 'The requested item could not be located.'
                        ]
                    ], 404);
                } else {
                    return response()->json([
                        'message' => 'Route not found.',
                        'errors' => [
                            'route' => 'The requested URL was not found.'
                        ]
                    ], 404);
                }
            }
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthenticated.',
                    'errors' => [
                        'authentication' => 'You must be logged in to access this resource.'
                    ]
                ], 401);
            }
        });

        $exceptions->render(function (AuthorizationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Forbidden.',
                    'errors' => [
                        'authorization' => 'You do not have permission to perform this action.'
                    ]
                ], 403);
            }
        });

        $exceptions->render(function (\Throwable $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Server error.',
                    'errors' => [
                        'exception' => $e->getMessage()
                    ]
                ], 500);
            }
        });

        $exceptions->render(function (JWTException $e, Request $request){
            if($request->expectsJson()){
                return response()->json([
                    'message' => 'Successfully logged out (token already invalid/missing)'
                ], 200);
            }
        });
    })->create();
