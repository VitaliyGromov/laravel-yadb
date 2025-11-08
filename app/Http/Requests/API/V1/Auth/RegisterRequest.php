<?php

declare(strict_types=1);

namespace App\Http\Requests\API\V1\Auth;

use App\Services\UserService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'string', 'email', 'min:1', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function after(): array
    {
        return [
            function(Validator $validator) {
                $email = $this->input('email');
                $service = app()->make(UserService::class);

                if (isset($email) && $service->existsByEmail($email)) {
                    $validator->errors()->add('email', 'Пользователь с таким email уже зарегистрирован.');
                }
            },
        ];
    }
}
