<?php

namespace App\Repositories;

use App\Models\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends BaseRepository<Request>
 *
 * @implements RequestRepositoryContract<Request>
 */
class RequestRepository extends BaseRepository implements RequestRepositoryContract
{
    protected string $model = Request::class;

    /**
     * @var string[]
     */
    protected array $allowFilters = [
        'name' => 'string',
        'email' => 'string',
        'status' => 'string',
        'created_at' => 'date', // Y-m-d
    ];

    public function getByFilters(array $filters = []): LengthAwarePaginator
    {
        return $this->applyFilters($filters);
    }

    public function find(int $id): ?Model
    {
        return $this->query->find($id);
    }

    /**
     * @param  array<string, string>  $filters
     * @return LengthAwarePaginator<Request>
     */
    private function applyFilters(array $filters = []): LengthAwarePaginator
    {
        $query = $this->query;

        foreach ($filters as $field => $value) {
            if (in_array($field, array_keys($this->allowFilters))) {
                switch ($this->allowFilters[$field]) {
                    case 'date':
                        $query->whereDate($field, date($value));
                        break;
                    case 'string':
                    default:
                        $query->where($field, $value);
                }

            }
        }

        $query
            ->when(array_key_exists('limit', $filters), function ($query) use ($filters) {
                $query->limit(data_get($filters, 'limit'));
            })
            ->when(array_key_exists('offset', $filters), function ($query) use ($filters) {
                $query->offset(data_get($filters, 'offset'));
            });

        return $query->paginate(
            data_get($filters, 'perPage', 10),
            ['*'],
            'page',
            data_get($filters, 'page', null),
        );

    }
}
