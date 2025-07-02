<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiteRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    
    public function rules(): array
    {
        return [
            'domain' => ['required','string','regex:/^[a-z0-9.-]+\.[a-z]{2,}$/i','unique:sites,domain'],
            'niche'  => ['nullable','string','max:120'],
        ];
    }

}
