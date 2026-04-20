<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'email' => ['required', 'string', 'email:rfc,dns'], // Memastikan format email @ dan domain . valid
        'password' => [
            'required', 
            'string',
            'min:8',             // Minimal 8 karakter
            'regex:/[a-z]/',      // Harus ada huruf kecil
            'regex:/[A-Z]/',      // Harus ada minimal 1 huruf kapital
            'regex:/[0-9]/',      // Harus ada minimal 1 angka
        ],
    ];
}

}
