<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModelClass of Model
 */
abstract class BaseRepository
{
    /**
     * @var Builder<TModelClass>
     */
    protected Builder $query;

    protected string $model;

    public function __construct()
    {
        $this->query = app($this->model)->query();
    }
}
