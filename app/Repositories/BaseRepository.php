<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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

    /**
     * @return Model|null
     */
    public function find(int $id)
    {
        return $this->query->find($id);
    }

    /**
     * @return Collection<int, TModelClass>
     */
    public function all(): Collection
    {
        return $this->query->get();
    }
}
