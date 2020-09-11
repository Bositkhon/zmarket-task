<?php

namespace App\Repositories;

use App\Interfaces\Repositories\EloquentRepositoryInterface;
use App\Interfaces\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

abstract class BaseEloquentRepository implements EloquentRepositoryInterface
{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $attributes) : Model
    {
        return $this->model->create($attributes);
    }

    public function find($condition) : ?Model
    {
        return $this->model->find($condition);
    }

}