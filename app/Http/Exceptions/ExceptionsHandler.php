<?php

namespace App\Http\Exceptions;

use Exception;
use Throwable;
use Modules\Core\Utilities\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Modules\Core\Exceptions\BaseException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ExceptionsHandler
{
    public function __invoke(Exception|Throwable $e)
    {
        $error = $e->getMessage();
        $statusCode = $e->getCode() == 0 ? Response::HTTP_NOT_FOUND : $e->getCode();

        switch (true) {

            case (($e instanceof NotFoundHttpException && str($e->getMessage())->contains('No results found.')) || $e instanceof ModelNotFoundException):
                $model = class_basename($e->getPrevious()->getModel());
                $error = "$model was not found.";
                break;

            case $e instanceof ValidationException:
                $messages = collect($e->errors())
                    ->map(fn ($error) => $error[0])
                    ->toArray();

                return response()->json([
                    'success' => false,
                    'message' => 'Validation errors occurred.',
                    'errors' => $messages,
                ], Response::HTTP_UNPROCESSABLE_ENTITY);

            case $e instanceof AuthenticationException:
                $error = 'Please login and try again.';
                $statusCode = Response::HTTP_UNAUTHORIZED;
                break;

            case $e instanceof QueryException:
                $error = 'A database error occurred.';
                $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                break;

            case $e instanceof AccessDeniedHttpException:
                $error = 'You are not authorized to perform this action.';
                $statusCode = Response::HTTP_UNAUTHORIZED;
                break;

            case $e instanceof LockTimeoutException:
                $error = "Something went wrong. Please try again later.";
                $statusCode = Response::HTTP_LOCKED;
                break;

            case $e instanceof BaseException:
                $error = $e->getMessage();
                $statusCode = $e->getCode();
                break;

            default:
                $error = 'An unexpected error occurred.';
                $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                break;
        }

        return (new Response())->error(message: $error, code: $statusCode);
    }
}
