<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TodoResource;
use App\Http\Requests\Todo\StoreTodoRequest;
use App\Http\Requests\Todo\UpdateTodoRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Todo項目に関する操作を提供するコントローラーです。
 */
class TodoController extends Controller
{
    /**
     * コンストラクタ
     *
     * @param TodoService $todoService
     */
    public function __construct(
        protected TodoService $todoService
    ){}

    /**
     * すべてのTodo項目を取得します。
     *
     * @return AnonymousResourceCollection Todo項目のコレクションを返します。
     */
    public function index(): AnonymousResourceCollection
    {
        $todos = $this->todoService->getAllTodos();
        return TodoResource::collection($todos);
    }

    /**
     * 新しいTodo項目を作成します。
     *
     * @param  StoreTodoRequest $request Todo作成に必要なデータを含むリクエスト
     * @return TodoResource              作成されたTodo項目を返します。
     */
    public function store(StoreTodoRequest $request): TodoResource
    {
        $attributes = $request->validated();
        $todo = $this->todoService->createTodo($attributes);
        return new TodoResource($todo);
    }

    /**
     * 指定されたTodo項目の詳細を取得します。
     *
     * @param  int          $todoId Todoの識別子
     * @return TodoResource         指定されたTodo項目を返します。
     */
    public function show(int $todoId): TodoResource
    {
        $todo = $this->todoService->getTodoById($todoId);
        return new TodoResource($todo);
    }

    /**
     * 指定されたTodo項目を更新します。
     *
     * @param  UpdateTodoRequest $request Todo更新に必要なデータを含むリクエスト
     * @param  Todo              $todo    更新するTodo項目
     * @return TodoResource               更新されたTodo項目を返します。
     */
    public function update(UpdateTodoRequest $request, Todo $todo): TodoResource
    {
        $attributes = $request->validated();
        $updatedTodo = $this->todoService->updateTodo($todo->id, $attributes);
        return new TodoResource($updatedTodo);
    }

    /**
     * 指定されたTodo項目を削除します。
     *
     * @param  int      $todoId 削除するTodoの識別子
     * @return Response         削除成功時は204 No Contentを返します。
     */
    public function destroy(int $todoId): Response
    {
        $this->todoService->deleteTodo($todoId);
        return response()->noContent();
    }
}
