<?php

namespace App\Http\Requests\Request;

use App\Enums\Status;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class StatusRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', 'max:255', Rule::in(Status::values())],
            'comment' => ['string', 'max:1024', 'required'],
        ];
    }
}
