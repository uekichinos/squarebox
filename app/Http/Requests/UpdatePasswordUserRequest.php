<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $id = $this->route('id');

        $user = User::find($id);
        return [
            'password' => ['required', 'confirmed', new Password($user->email)],
            'password_confirmation' => 'required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'password' => 'Password',
            'password_confirmation' => 'Re-Password',
        ];
    }
}
