<?php

namespace App\Http\Controllers\Api;

use App\Support\Api;
use RuntimeException;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use App\Components\Eloquent\Authenticatable;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Components\Eloquent\Concerns\Filterable;
use Illuminate\Database\Eloquent\Relations\Relation;

class ApiController extends Controller
{
    protected function indexAction($request,$model, bool|null $paginate = true,array $filters = []): Api
    {
        $request ??= request();

        if (is_string($model) && !method_exists($model, 'query')) {
            throw new RuntimeException('Index action parameter type incorrect');
        } elseif (is_string($model)) {
            $model = new $model;
        }

        if (($model instanceof Collection) || ($model instanceof LengthAwarePaginator) || is_array($model)) {
            return api($model)->setMessage('Data fetched successfully');
        }

        $instance = $model;

        if ($model instanceof Relation || $model instanceof Builder) {
            $instance = $model->getModel();
        }

        if (in_array(Filterable::class, class_uses_recursive($instance))) {
            if ($model instanceof Relation || $model instanceof Builder) {
                $model = $instance->asFilter(filters: $filters, request: $request, builder: $model);
            } else {
                $model = $model->asFilter(filters: $filters, request: $request);
            }
        }

        if ($paginate) {
            $result = $model->paginate($request->perPage());
        } else {
            $result = $model->get();
        }

        return api($result)->ok()->setMessage('Data fetched successfully');
    }

}
