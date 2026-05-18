<?php

declare(strict_types=1);

namespace Modules\Contact\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_id'         => ['nullable', 'integer', 'exists:services,id'],
            'email'              => ['required', 'email', 'max:150'],
            'phone'              => ['nullable', 'string', 'max:30', 'regex:/^[\d\s()\-+.]+$/'],
            'phone_country_code' => ['nullable', 'string', 'max:10'],
            'source'             => ['nullable', 'string', 'max:50'],
        ];
    }
}
