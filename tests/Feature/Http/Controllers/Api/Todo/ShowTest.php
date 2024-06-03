<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Todo;

uses(RefreshDatabase::class);

test('認証済みのユーザーが特定のTodoの詳細情報を取得できること', function () {
    $user = User::factory()->create();
    $todo = Todo::factory()->create([
        'user_id' => $user->id,
        'title' => '具体的なTodo',
        'description' => '具体的な説明'
    ]);

    $response = $this->actingAs($user)->getJson("/api/todos/{$todo->id}");

    $response->assertStatus(200);
    $response->assertJson([
        'data' => [
            'title' => '具体的なTodo',
            'description' => '具体的な説明'
        ]
    ]);
});
