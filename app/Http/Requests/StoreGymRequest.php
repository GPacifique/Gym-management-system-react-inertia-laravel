<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGymRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // or CheckRole middleware
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'owner_id' => 'nullable|exists:users,id',
        ];
    }
}