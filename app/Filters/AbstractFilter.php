<?php

namespace App\Filters;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

abstract class AbstractFilter
{
    /**
     * Query Builder instance.
     */
    protected Builder $builder;

    /**
     * Request instance.
     */
    protected Request $request;

    /**
     * Create instance.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply Filtering
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        collect($this->request->filter)->each(function ($items, $key) {
            $method = Str::camel(trim($key));

            // Skip if method doesn't exist
            if (! method_exists($this, $method)) {
                return true;
            }

            try {
                call_user_func_array(
                    [$this, $method],
                    array_filter([$items], fn ($searchTerm) => strlen(trim($searchTerm)) >= 1)
                );
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        });

        return $this->builder;
    }
}