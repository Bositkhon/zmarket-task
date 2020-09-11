<?php

namespace App\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    /**
     * Creates a record
     *
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes) : Model;

    /**
     * Finds a records by condition or identifier
     *
     * @param int|array $condition
     * @return Model|null
     */
    public function find($condition) : ?Model;
}