<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use \Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    //Override na mensagem de autenticação
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) 
        {
            return response()->json([
                'code'    => 1,
                'message' => $exception->getMessage(),    
            ], 401);            

            //return response()->json(['error' => 'Unauthenticated.'], 401);
        }
    }

    //Override json response
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'code'    => $exception->status,
            'message' => $exception->getMessage(),
            'errors'  => $this->transformErrors($exception),

        ], $exception->status);
    }

// transform the error messages,
    private function transformErrors(ValidationException $exception)
    {
        $errors = [];

        foreach ($exception->errors() as $field => $message) {
           $errors[] = [
               'field' => $field,
               'code' => $message[0],
           ];
        }

        return $errors;
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
