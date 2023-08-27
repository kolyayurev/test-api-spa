<?php

namespace App\Repositories;

use App\Models\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends BaseRepository<Request>
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

    public function getByFilters(array $filters = []): Collection
    {
        $this->applyFilters($filters);

        return $this->query->get();
    }

    public function find(int $id): ?Model
    {
        return $this->query->find($id);
    }

    /**
     * @param  array<string, string>  $filters
     */
    private function applyFilters(array $filters = []): void
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

        $this->query = $query
            ->when(array_key_exists('limit', $filters), function ($query) use ($filters) {
                $query->limit(data_get($filters, 'limit'));
            })
            ->when(array_key_exists('offset', $filters), function ($query) use ($filters) {
                $query->offset(data_get($filters, 'offset'));
            });

    }
}
