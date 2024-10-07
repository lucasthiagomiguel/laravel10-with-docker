<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Adicionando tratamento para exceções de validação
        $this->renderable(function (ValidationException $e, $request) {
            return response()->json([
                'error' => 'Validation error',
                'messages' => $e->validator->errors(),
            ], 422);
        });

        // Adicionando tratamento para exceções genéricas
        $this->renderable(function (Throwable $e, $request) {
            return response()->json([
                'error' => 'Ocorreu um erro',
                'message' => $e->getMessage(),
            ], 500);
        });
    }
}
