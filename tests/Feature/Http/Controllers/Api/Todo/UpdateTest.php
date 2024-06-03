<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Todo;

uses(RefreshDatabase::class);

test('認証済みのユーザーが特定のTodoを更新できること', function () {
    $user = User::factory()->create();
    $todo = Todo::factory()->create([
        'user_id' => $user->id,
        'title' => '更新前のタイトル',
        'description' => '更新前の説明',
        'is_completed' => false,
        'due_date' => '2024-11-01',
    ]);

    $updateData = [
        'title' => '更新後のタイトル',
        'description' => '更新後の説明'
    ];

    $response = $this->actingAs($user)->putJson("/api/todos/{$todo->id}", $updateData);

    $response->assertStatus(200);
    $response->assertJson([
        'data' => [
            'id' => $todo->id,
            'title' => '更新後のタイトル',
            'description' => '更新後の説明',
            'is_completed' => false,
            'due_date' => '2024-11-01',
            'created_at' => $todo->created_at->toJSON(),
            'updated_at' => $todo->updated_at->toJSON(),
        ]
    ]);

    $this->assertDatabaseHas('todos', [
        'id' => $todo->id,
        'title' => '更新後のタイトル',
        'description' => '更新後の説明'
    ]);
});
