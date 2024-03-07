<?php

namespace App\Components\Eloquent\Concerns;

trait ResolveRouteBinding
{
    public function resolveRouteBinding($value, $field = null)
    {
        $builder = $this;

        if (method_exists($this,'asFilter')) {
            $builder = $this->asFilter();
        }

        return $builder->where($field ?? $this->getRouteKeyName(),$value)->firstOrFail();
    }
}
