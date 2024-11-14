<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SmfResponse;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e): Response|SmfResponse
    {
        if ($e instanceof ThrottleRequestsException) {
            if ($request->routeIs('url.store')) {
                return response()->view('errors.url-429', [], SmfResponse::HTTP_TOO_MANY_REQUESTS);
            }

            // Default behavior for ThrottleRequestsException
            return parent::render($request, $e);
        }

        return parent::render($request, $e);
    }
}
