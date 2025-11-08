<?php

declare(strict_types=1);

namespace App\Http\Requests\API\V1\Auth;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'min:1', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    public function after(): array
    {
        return [
            function(Validator $validator) {
                $service = app()->make(UserService::class);

                /**
                 * @var User $user
                 */
                $user = rescue(fn() => $service->findByEmail($this->input('email')), report: false);

                if (!$user) {
                    $validator->errors()->add(
                        'email',
                        'Не найден пользователь с таким адресом электронной почты'
                    );

                    return;
                }

                if (!Hash::check($this->input('password'), $user->password)) {
                    $validator->errors()->add(
                        'password',
                        'Проверьте правильность пароля',
                    );
                }
            },
        ];
    }
}
