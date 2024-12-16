<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * @param mixed $request
     * @param Throwable $exception
     * 
     * @return [type]
     */
    public function render($request, Throwable $exception)
    {
        $statusCode = method_exists($exception, 'getStatusCode')
            ? $exception->getStatusCode()
            : 500;

        if ($request->is('api/*')) {
            return match (true) {
                $exception instanceof ModelNotFoundException,
                $exception instanceof NotFoundHttpException => response()->json(
                    ['error' => 'Resource not found'],
                    404
                ),
                
                $exception instanceof \Illuminate\Validation\ValidationException => response()->json(
                    [
                        'error' => 'Validation failed',
                        'messages' => $exception->errors(),
                    ],
                    422
                ),
    
                $exception instanceof \Symfony\Component\HttpKernel\Exception\BadRequestHttpException,
                $exception instanceof \InvalidArgumentException,
                $exception instanceof \Illuminate\Database\QueryException => response()->json(
                    ['error' => 'Validation failed'],
                    422
                ),
    
                default => response()->json(
                    [
                        'error' => 'Something went wrong',
                        'message' => $exception->getMessage(),
                    ],
                    $statusCode
                ),
            };
        }

        return parent::render($request, $exception);
    }
}
