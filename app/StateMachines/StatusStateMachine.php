<?php

namespace App\StateMachines;

use App\Enums\Status;
use App\Events\RequestStatusChanged;
use Asantibanez\LaravelEloquentStateMachines\StateMachines\StateMachine;

class StatusStateMachine extends StateMachine
{
    public function recordHistory(): bool
    {
        return true;
    }

    /**
     * @return array<string, string[]>>
     */
    public function transitions(): array
    {
        return [
            Status::active->value => [Status::resolved->value],
            Status::resolved->value => [Status::active->value],
        ];
    }

    public function defaultState(): string
    {
        return Status::active->value;
    }

    /**
     * @return array<string, mixed>
     */
    public function afterTransitionHooks(): array
    {
        return [
            Status::resolved->value => [
                function ($from, $model) {
                    event(new RequestStatusChanged($model));
                },
            ],
        ];
    }
}
