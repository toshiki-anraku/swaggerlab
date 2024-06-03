<?php
declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ユーザーログイン時のバリデーションルールを管理します。
 */
class LoginRequest extends FormRequest
{
    /**
     * リクエストを行うユーザーが認証を必要としないことを示します。
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * ログインに必要なバリデーションルールを定義します。
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }
}
