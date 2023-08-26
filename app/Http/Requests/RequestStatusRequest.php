<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Validation\Rule;

class RequestStatusRequest extends BaseRequest
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
