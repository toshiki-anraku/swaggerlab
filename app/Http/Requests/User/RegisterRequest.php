<?php
declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ユーザー登録時のバリデーションルールを管理します。
 */
class RegisterRequest extends FormRequest
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
     * 登録に必要なバリデーションルールを定義します。
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}
