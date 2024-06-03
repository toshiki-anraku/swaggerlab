<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Todo;

uses(RefreshDatabase::class);

test('認証済みのユーザーが特定のTodoを削除できること', function () {
    $user = User::factory()->create();
    $todo = Todo::factory()->create([
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->deleteJson(route('todos.destroy', $todo));

    $response->assertNoContent();
    $this->assertDatabaseMissing('todos', $todo->toArray());
});
