<?php
declare(strict_types=1);

namespace App\Http\Requests\Todo;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Todoの作成リクエストのバリデーションを処理します。
 */
class StoreTodoRequest extends FormRequest
{
    /**
     * リクエストを行うユーザーが認証されているか確認します。
     *
     * @return bool 認証が必要な場合はtrue、それ以外はfalse
     */
    public function authorize(): bool
    {
        return true; // ここを適切な認証ロジックに変更してください。
    }

    /**
     * リクエストに適用されるバリデーションルールを定義します。
     *
     * @return array<string, mixed> バリデーションルール
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => 'boolean',
            'due_date' => 'nullable|date'
        ];
    }
}
