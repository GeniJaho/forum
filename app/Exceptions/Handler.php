<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
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
        //
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            if ($request->wantsJson()) {
                return response('Sorry, failed validation.', 422);
            }
        }

        if ($e instanceof ThrottleRequestsException) {
            if ($request->wantsJson()) {
                return response(
                    'Your are posting too frequently. Please take a break. :)',
                    $e->getStatusCode()
                );
            }
        }

        return parent::render($request, $e);
    }
}
