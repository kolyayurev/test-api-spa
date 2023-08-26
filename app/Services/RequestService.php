<?php

namespace App\Services;

use App\Models\Request;

/**
 * @extends BaseService<Request>
 */
class RequestService extends BaseService
{
    protected string $model = Request::class;

    public function changeStatus(int $id, string $status, string $comment = null): bool
    {
        /**
         * @var Request|null $model
         */
        $model = $this->query->find($id);

        $model?->status()->transitionTo($status, ['comment' => $comment]);

        return true;
    }
}
