<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

uses(RefreshDatabase::class);

test('認証済みのユーザーが新しいTodoを作成できること', function () {
    $user = User::factory()->create();
    $todoData = [
        'title' => '新規Todo',
        'description' => 'これは新しく追加されるTodoです。'
    ];

    $response = $this->actingAs($user)->postJson('/api/todos', $todoData);

    $response->assertStatus(201);
    $response->assertJsonStructure([
        'data' => [
            'id',
            'title',
            'description',
            'is_completed',
            'due_date',
            'created_at',
            'updated_at'
        ]
    ]);

    $data = $response->json('data');
    $this->assertEquals('新規Todo', $data['title']);
    $this->assertEquals('これは新しく追加されるTodoです。', $data['description']);

    $this->assertDatabaseHas('todos', [
        'title' => '新規Todo',
        'description' => 'これは新しく追加されるTodoです。',
        'user_id' => $user->id
    ]);
});
