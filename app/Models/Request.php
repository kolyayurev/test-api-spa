<?php

namespace App\Models;

use App\Enums\Status;
use App\StateMachines\StatusStateMachine;
use Asantibanez\LaravelEloquentStateMachines\Traits\HasStateMachines;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Landing
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Status $status
 * @property string $message
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method \Asantibanez\LaravelEloquentStateMachines\StateMachines\State status()
 */
class Request extends Model
{
    use HasFactory;
    use HasStateMachines;

    protected $fillable = [
        'name',
        'email',
        'message',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d',
    ];

    /**
     * @var array<string, string>
     */
    public array $stateMachines = [
        'status' => StatusStateMachine::class,
    ];
}
