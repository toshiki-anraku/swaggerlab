<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Todo;

uses(RefreshDatabase::class);

test('認証済みのユーザーが自分のTodo一覧を取得できること', function () {
    $user = User::factory()->create();
    $todos = Todo::factory()->count(3)->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->getJson('/api/todos');

    $response->assertStatus(200);
    $response->assertJsonCount(3, 'data');
    foreach ($todos as $todo) {
        $response->assertJsonFragment([
            'id' => $todo->id,
            'title' => $todo->title
        ]);
    }
});
