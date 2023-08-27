<?php

namespace App\Http\Requests\Request;

/*
 * Да, тавтология :)
 */

use App\Http\Requests\BaseRequest;

class StoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255', 'required'],
            'email' => ['email', 'max:255', 'required'],
            'message' => ['string', 'max:1024', 'required'],
        ];
    }
}
