<?php
declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * 既存ユーザー情報の更新のためのリクエストバリデーションを定義します。
 */
class UpdateUserRequest extends FormRequest
{
    /**
     * リクエストの認可を行います。
     * ユーザーが自分自身の情報を更新することのみ許可します。
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // ここでは単純化のためにtrueを返していますが、実際には認証されたユーザーが自分の情報のみ更新できるようにする必要があります。
        return true;
    }

    /**
     * リクエストで適用されるバリデーションルールを返します。
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user())],
            'password' => 'sometimes|string|min:6|confirmed',
        ];
    }
}
