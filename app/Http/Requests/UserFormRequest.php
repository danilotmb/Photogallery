<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
{
    $id = $this->user ? $this->user->id : null;
    $emailRule = $id? Rule::unique('users')->ignore($id) : Rule::unique('users');
    return [
        'name' => ['required', 'string', 'max:255'],
        'email' => [
            'required', 'string', 'email', 'max:255',
            $emailRule
        ],
        'user_role' => ['required', Rule::in(['user', 'admin'])],
    ];
}
}
