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
             'name' => ['required', 'string', 'max:255'],
        'slug' => ['required', 'string', 'unique:gyms,slug'],
        'email' => ['required', 'email', 'unique:gyms,email'],
        'phone' => ['nullable', 'string'],
        'country' => ['nullable', 'string'],
        'city' => ['nullable', 'string'],
        'address' => ['nullable', 'string'],
        'logo' => ['nullable', 'image'],
        'status' => ['required'],
        'owner_id' => ['nullable', 'exists:users,id'],
        'subscription_plan_id' => ['nullable', 'exists:saas_plans,id'],
        'subscription_expires_at' => ['nullable', 'date'],
        ];
    }
}