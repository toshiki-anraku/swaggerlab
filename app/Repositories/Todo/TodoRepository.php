<?php
declare(strict_types=1);

namespace App\Repositories\Todo;

use App\Models\Todo;
use Illuminate\Support\Collection;

/**
 * Todoモデルに対する具体的なデータ操作を提供します。
 */
class TodoRepository implements TodoRepositoryInterface
{
    /**
     * すべてのTodo項目を取得します。
     *
     * @return Collection Todo項目のコレクション
     */
    public function getAll(): Collection
    {
        return Todo::all();
    }

    /**
     * 新しいTodo項目をデータベースに作成します。
     *
     * @param  array $attributes Todoの属性
     * @return Todo              作成されたTodoオブジェクト
     */
    public function create(array $attributes): Todo
    {
        return Todo::create($attributes);
    }

    /**
     * 指定されたIDのTodo項目を検索します。
     *
     * @param  int       $id TodoのID
     * @return Todo|null     見つかったTodoオブジェクト、存在しない場合はnull
     */
    public function findById(int $id): ?Todo
    {
        return Todo::find($id);
    }

    /**
     * 指定されたTodo項目を更新します。
     *
     * @param  Todo  $todo       更新するTodoオブジェクト
     * @param  array $attributes 更新する属性
     * @return Todo              更新されたTodoオブジェクト
     */
    public function update(Todo $todo, array $attributes): Todo
    {
        $todo->update($attributes);
        return $todo;
    }

    /**
     * 指定されたTodo項目を削除します。
     *
     * @param Todo $todo 削除するTodoオブジェクト
     */
    public function delete(Todo $todo): void
    {
        $todo->delete();
    }
}
