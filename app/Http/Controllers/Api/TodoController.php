<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Todo\StoreTodoRequest;
use App\Http\Requests\Todo\UpdateTodoRequest;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TodoController extends Controller
{
    /**
     * Todoの一覧を取得します。
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $todos = Todo::all();
        return TodoResource::collection($todos);
    }

    /**
     * 新しいTodoを作成します。
     *
     * @param  StoreTodoRequest  $request
     * @return TodoResource
     */
    public function store(StoreTodoRequest $request): TodoResource
    {
        $todo = Todo::create($request->validated());
        return new TodoResource($todo);
    }

    /**
     * 指定されたTodoの詳細情報を取得します。
     *
     * @param  Todo  $todo
     * @return TodoResource
     */
    public function show(Todo $todo): TodoResource
    {
        return new TodoResource($todo);
    }

    /**
     * 指定されたTodoを更新します。
     *
     * @param  UpdateTodoRequest  $request
     * @param  Todo  $todo
     * @return TodoResource
     */
    public function update(UpdateTodoRequest $request, Todo $todo): TodoResource
    {
        $todo->update($request->validated());
        return new TodoResource($todo);
    }

    /**
     * 指定されたTodoを削除します。
     *
     * @param  Todo  $todo
     * @return Response
     */
    public function destroy(Todo $todo): Response
    {
        $todo->delete();
        return response()->noContent();
    }
}
