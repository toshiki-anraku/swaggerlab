<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Todo\TodoRepositoryInterface;
use Illuminate\Support\Collection;
use App\Models\Todo;

/**
 * Todoに関連するビジネスロジックを担当するサービスクラスです。
 */
class TodoService
{
    /**
     * コンストラクタ
     *
     * @param TodoRepositoryInterface $todoRepository
     */
    public function __construct(
        protected TodoRepositoryInterface $todoRepository
    ){}

    /**
     * すべてのTodo項目を取得します。
     *
     * @return Collection Todo項目のコレクション
     */
    public function getAllTodos(): Collection
    {
        return $this->todoRepository->getAll();
    }

    /**
     * 新しいTodo項目を作成します。
     *
     * @param  array $attributes Todoの属性
     * @return Todo              作成されたTodoオブジェクト
     */
    public function createTodo(array $attributes): Todo
    {
        return $this->todoRepository->create($attributes);
    }

    /**
     * 指定されたIDのTodo項目を取得します。
     *
     * @param  int       $id TodoのID
     * @return Todo|null     見つかったTodoオブジェクト、存在しない場合はnull
     */
    public function getTodoById(int $id): ?Todo
    {
        return $this->todoRepository->findById($id);
    }

    /**
     * 指定されたTodo項目を更新します。
     *
     * @param  array $attributes 更新する属性
     * @param  int   $todoId     更新するTodoのID
     * @return Todo              更新されたTodoオブジェクト
     */
    public function updateTodo(int $todoId, array $attributes): Todo
    {
        $todo = $this->getTodoById($todoId);
        if (!$todo) {
            throw new \Exception("Todo not found.");
        }
        return $this->todoRepository->update($todo, $attributes);
    }

    /**
     * 指定されたIDのTodo項目を削除します。
     *
     * @param int $todoId 削除するTodoのID
     */
    public function deleteTodo(int $todoId): void
    {
        $todo = $this->getTodoById($todoId);
        if (!$todo) {
            throw new \Exception("Todo not found.");
        }
        $this->todoRepository->delete($todo);
    }
}
