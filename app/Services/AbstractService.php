<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class AbstractService
{
    /**
     * The model of the Service
     */
    protected Model $model;

    /**
     * Create the instance.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}