<?php

namespace App\Repositories;

use App\Models\Request;

/**
 * @extends BaseRepository<Request>
 */
class RequestRepository extends BaseRepository
{
    protected string $model = Request::class;

    /**
     * @param  array<string, mixed>  $filters
     * @return \Illuminate\Database\Eloquent\Collection<int, Request>
     */
    public function getByFilters(array $filters = [])
    {
        // TODO: filters and pagination

        return $this->query->get();
    }
}
