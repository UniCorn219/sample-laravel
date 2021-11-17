<?php

namespace App\Exceptions;

use App\Contracts\ResponseTrait;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    use ResponseTrait;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        ResourceNotFoundException::class,
        ThreadDoesNotBelongToUserException::class,
        ThreadDoesNotBlockByUserException::class,
        MaxStoreReachedException::class,
        BusinessException::class,
        BalanceNotEnough::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function shouldntReport(Throwable $e): bool
    {
        if (app()->environment('local')) {
            return true;
        }

        return parent::shouldntReport($e);
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

    /**
     * @param Request $request
     * @param Throwable $e
     *
     * @return JsonResponse|Response|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response|JsonResponse|\Symfony\Component\HttpFoundation\Response
    {
        if (app()->environment('local')) Log::error($e);
        if ($e instanceof ValidationException) {
            return $this->responseValidateFailed($e->errors());
        }

        if ($e instanceof AuthenticationException) {
            return $this->responseUnauthorized('token_expired');
        }

        if ($e instanceof AuthorizationException) {
            return $this->responseUnauthorized('unauthenticated', Response::HTTP_FORBIDDEN);
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->responseNotFound();
        }

        if ($e instanceof ModelNotFoundException) {
            $message = $e->getMessage();
            return $this->responseNotFound($message);
        }

        if (!app()->environment('local') && !in_array(get_class($e), $this->dontReport)) {
            Bugsnag::notifyException($e);
        }

        if ($e instanceof BusinessException) {
            return $this->error($e->getMessage(), $e->getCode(), $e->getExceptionCode());
        }

        if ($e instanceof BaseException) {
            return $this->responseErrorInternal($e->getMessage(), $e->getCode());
        }

        return $this->responseErrorInternal('http_internal_error');
    }
}
