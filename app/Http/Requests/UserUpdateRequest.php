<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->route('user');
        // Admin can update any user, or user can update themselves
        return $this->user() && ($this->user()->role === 1 || $this->user()->id === $user->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $userId],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'id_country' => ['nullable', 'integer', 'exists:countries,id_country'],
            'role' => ['nullable', 'integer', 'in:1,2'],
            'status' => ['nullable', 'integer', 'in:0,1'],
        ];
    }
}
