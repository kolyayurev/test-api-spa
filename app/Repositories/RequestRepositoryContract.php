<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModelClass of Model
 */
interface RequestRepositoryContract
{
    /**
     * @param  array<string, mixed>  $filters
     * @return LengthAwarePaginator<TModelClass>
     */
    public function getByFilters(array $filters = []): LengthAwarePaginator;

    public function find(int $id): ?Model;
}
