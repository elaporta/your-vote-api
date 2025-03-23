<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Foundation\Configuration\Middleware;

// Exceptions
use App\Exceptions\ApplicaitonHeaderException;
use App\Exceptions\BadRequestException;
use App\Exceptions\UnauthorizedException;
use App\Exceptions\InternalServerErrorException;

return Application::configure(basePath: dirname(__DIR__))
    // Routes
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        apiPrefix: '',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    // Middlewares
    ->withMiddleware(function (Middleware $middleware) {
        //
    })

    // Exceptions
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Throwable $e, Request $request) {

            // Accept application/json header
            if (!$request->expectsJson()) throw new ApplicaitonHeaderException();

            // Validation exceptions
            if ($e instanceof ValidationException) throw new BadRequestException($e->errors());

            // Authentication exceptions
            if ($e instanceof \Illuminate\Auth\AuthenticationException) throw new UnauthorizedException($e->getMessage());

            // Internal server errors
            throw new InternalServerErrorException($e->getMessage(), (config('app.debug') === true) ? $e->getTrace() : null);
        });
    })->create();
