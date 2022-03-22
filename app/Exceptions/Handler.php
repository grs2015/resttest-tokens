<?php

namespace App\Exceptions;

use Throwable;
use App\Traits\ApiResponser;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\ItemNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;

    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
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

        $this->renderable(function (Throwable $e) {

            if ($e instanceof ValidationException) {
                $errors = $e->errors();

                return $this->errorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if ($e instanceof NotFoundHttpException) {
                if ($e->getPrevious() instanceof ModelNotFoundException) {
                    $modelName = strtolower(class_basename($e->getPrevious()->getModel()));
                    $messageException = "Does not exists {$modelName} with the specified ID";
                } else {
                    $messageException = "The specified URL can't be found";
                }

                return $this->errorResponse($messageException, Response::HTTP_NOT_FOUND);
            }

            if ($e instanceof ItemNotFoundException) {
                return $this->errorResponse('Can\'t find the item in collection', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            if ($e instanceof AuthenticationException) {
                return $this->errorResponse('Unauthenticated', Response::HTTP_UNAUTHORIZED);
            }

            if ($e instanceof AuthorizationException) {
                return $this->errorResponse($e->getMessage(), Response::HTTP_FORBIDDEN);
            }

            if ($e instanceof MethodNotAllowedHttpException) {
                return $this->errorResponse('The specified method for the request is invalid', Response::HTTP_METHOD_NOT_ALLOWED);
            }

            if ($e instanceof HttpException) {
                return $this->errorResponse($e->getMessage(), $e->getStatusCode());
            }

            if ($e instanceof QueryException) {
                $errorCode = $e->errorInfo[1];
                if ($errorCode == 1451) {
                    return $this->errorResponse('Cannot remove this resource permanently. It is related to some another resources', Response::HTTP_CONFLICT);
                }
            }

            if (!config('app.debug')) {
                return $this->errorResponse('Unexpected Exception. Try later', Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });
    }
}
