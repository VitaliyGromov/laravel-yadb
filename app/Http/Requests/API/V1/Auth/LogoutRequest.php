<?php

declare(strict_types=1);

namespace App\Http\Requests\API\V1\Auth;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class LogoutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'string', 'uuid'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => $this->route('user_id'),
        ]);
    }

    public function after(): array
    {
        return [
            function(Validator $validator) {
                $service = app()->make(UserService::class);

                /**
                 * @var User $user
                 */
                $user = rescue(fn() => $service->find($this->get('user_id')), report: false);

                if (!$user) {
                    $validator->errors()->add('user_id', 'Пользователь не найден');
                }
            },
        ];
    }
}
