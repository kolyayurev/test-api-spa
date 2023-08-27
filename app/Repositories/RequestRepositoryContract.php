<?php

namespace App\Repositories;

use App\Models\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RequestRepositoryContract
{
    /**
     * @param  array<string, mixed>  $filters
     * @return Collection<int, Request>
     */
    public function getByFilters(array $filters = []): Collection;

    public function find(int $id): ?Model;
}
