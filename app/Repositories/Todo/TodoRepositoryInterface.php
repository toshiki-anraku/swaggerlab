<?php
declare(strict_types=1);

namespace App\Repositories\Todo;

use App\Models\Todo;
use Illuminate\Support\Collection;

/**
 * Todoエンティティに対するデータアクセスを抽象化するインターフェースです。
 */
interface TodoRepositoryInterface
{
    /**
     * すべてのTodo項目を取得します。
     *
     * @return Collection Todo項目のコレクション
     */
    public function getAll(): Collection;

    /**
     * 新しいTodo項目をデータベースに作成します。
     *
     * @param  array $attributes Todoの属性
     * @return Todo              作成されたTodoオブジェクト
     */
    public function create(array $attributes): Todo;

    /**
     * 指定されたIDのTodo項目を検索します。
     *
     * @param  int       $id TodoのID
     * @return Todo|null     見つかったTodoオブジェクト、存在しない場合はnull
     */
    public function findById(int $id): ?Todo;

    /**
     * 指定されたTodo項目を更新します。
     *
     * @param  Todo  $todo       更新するTodoオブジェクト
     * @param  array $attributes 更新する属性
     * @return Todo              更新されたTodoオブジェクト
     */
    public function update(Todo $todo, array $attributes): Todo;

    /**
     * 指定されたTodo項目を削除します。
     *
     * @param Todo $todo 削除するTodoオブジェクト
     */
    public function delete(Todo $todo): void;
}
