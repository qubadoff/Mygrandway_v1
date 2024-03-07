<?php

namespace App\Exceptions;

use App\Support\Api;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Spatie\LaravelIgnition\Exceptions\CannotExecuteSolutionForNonLocalIp;
use Spatie\QueryBuilder\Exceptions\InvalidQuery;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
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
        InvalidQuery::class,
        CannotExecuteSolutionForNonLocalIp::class,
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


    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e): Api|JsonResponse|Response|RedirectResponse
    {
        if (str_starts_with($request->path(),'api/')) {
            return $this->renderException($e, $request);
        }

        return parent::render($request,$e);
    }


    private function renderException($e, $request = null): JsonResponse|Response
    {
        $message = $e->getMessage();

        $code = $this->getCode($e);

        $error['message'] = $message;

        if ($e instanceof ValidationException) {
            $error['message']    = json_decode($message,true);
            $message             = "The given data was invalid.";
            $error['validation'] = $e?->validator?->errors();
        }

        if ($e instanceof ModelNotFoundException) {
            $error['message']  = $message = "The requested resource was not found.";
        }

        if (config('app.debug')) {
            $error = [...$error,...[
                'code'      => $code,
                'exception' => class_basename($e),
            ]];
        }
        return api()->setCode($code)->setError($error)->setMessage($message)->e($e)->toResponse($request);
    }

    private function getCode($e): int
    {
        return $this->getCodeFromException($e);
    }


    private function getCodeFromException($e): int
    {
        if ($this->isHttpException($e)) {
            return $e->getStatusCode();
        }

        if ($e instanceof UnauthorizedHttpException) {
            return 403;
        }

        if ($e instanceof AuthorizationException) {
            return 403;
        }

        if ($e instanceof AuthenticationException) {
            return 401;
        }

        if ($e instanceof ValidationException) {
            return 422;
        }

        if ($e instanceof OtpException) {
            return 400;
        }

        if ($e instanceof ModelNotFoundException) {
            return 404;
        }

        return 500;
    }
}
