<?php

namespace App\Support;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\Pure;
use Throwable;

class Api implements Responsable
{
    use Conditionable;

    public mixed $error;

    private bool $debug;

    private ?Throwable $exception = null;

    private ?array $filters = null;


    public function __construct(
        public mixed   $data = [],
        public bool    $success = true,
        public int     $code = 200,
        public ?string $message = null,
        public array   $extra = []
    )
    {
    }

    /**
     * @return static
     */
    #[Pure]
    public static function make(): self
    {
        return new static(...func_get_args());
    }

    public function e($e): static
    {
        return $this->setException($e);
    }

    public function setException($exception): self
    {
        $this->exception = $exception;
        $this->success = false;

        return $this;
    }

    public function mt($key): static
    {
        return $this->setMessage(trans($key));
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function et($key): static
    {
        return $this->setError(trans($key));
    }

    public function setError($error): static
    {
        $this->error = $error;
        $this->success = false;

        return $this;
    }

    public function ok($bool = true): static
    {
        $this->success = (bool)$bool;

        return $this;
    }

    public function setExtra(array $extra): static
    {
        $this->extra = $extra;

        return $this;
    }

    public function setQueryFilters(array $filters): static
    {
        $this->filters = $filters;

        return $this;
    }

    public function setData($data): static
    {
        $this->data = $data;

        return $this;
    }

    public function mergeData($data): static
    {
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    /**
     * @return $this
     * @noinspection PhpUnused
     */
    public function enableDebug(): static
    {
        $this->debug = true;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(Request $request = null): array
    {
        $debug = $this->debug ?? config('app.debug');

        $request ??= request();

        $response = [
            'success'    => $this->success,
            'code'       => $this->code,
            'data'       => $this->data,
            'pagination' => $this->data instanceof LengthAwarePaginator,
            'message'    => $this->message ?? "",
            'error'      => $this->error ?? null,
        ];

        if ($debug && $this->exception) {
            $response['exception'] = [
                'message' => $this->exception->getMessage(),
                'line'    => $this->exception->getLine(),
                'file'    => $this->exception->getFile(),
            ];

            if ($this->exception instanceof ValidationException) {
                unset($response['error']);
                $response['error']['validation'] = $this->exception->errors();
            }
        }


        if ($debug) {
            $response['debug'] = [
                'request' => [
                    'method' => $request->method(),
                    'params' => $request->all(),
                    'time'   => defined('LARAVEL_START')
                        ? number_format(microtime(true) - LARAVEL_START, 3) * 1000 . " ms"
                        : null,
                    //'headers' => request()->headers->all()
                ],
                'query'   => DB::getQueryLog(),
                'route'   => Route::getCurrentRoute()?->getAction() ?: request()->path(),
            ];

            if ($this->filters) {
                $response['filters'] = $this->filters;
            }
        }


        return $response;
    }

    public function __toString(): string
    {
        return $this->toJson();
    }

    public function toJson($options = 0): bool|string
    {
        return json_encode($this->toArray(), $options);
    }

    public function toManyRequest(): static
    {
        return $this->setCode(Response::HTTP_BAD_REQUEST);
    }

    public function setCode($code): static
    {
        $this->code = $code;

        if ($this->code >= 400) {
            $this->notOk();
        }

        return $this;
    }

    public function notOk(): static
    {
        $this->success = false;

        return $this;
    }

    public function badRequest(): static
    {
        return $this->setCode(Response::HTTP_BAD_REQUEST);
    }

    public function noContent(): static
    {
        return $this->setCode(Response::HTTP_NO_CONTENT);
    }

    public function notFound(): static
    {
        return $this->setCode(Response::HTTP_NOT_FOUND);
    }

    public function created(): static
    {
        return $this->setCode(Response::HTTP_CREATED);
    }

    public function unprocessableEntity(): static
    {
        return $this->setCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function internalServerError(): static
    {
        return $this->setCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function send(): JsonResponse|Response
    {
        return $this->toResponse()->send();
    }

    public function toResponse($request = null): JsonResponse|Response
    {
        return response()->json($this->toArray($request), $this->code);
    }
}
