<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

uses(RefreshDatabase::class);

test('認証済みのユーザーが自分の情報を更新できること', function () {
    $user = User::factory()->create([
        'name' => '初期ユーザー',
        'email' => 'initial@example.com'
    ]);

    $updatedData = [
        'name' => '更新ユーザー',
        'email' => 'updated@example.com'
    ];

    $response = $this->actingAs($user)->putJson("/api/user/{$user->id}/update", $updatedData);

    $response->assertStatus(200);
    $response->assertJson([
        'name' => '更新ユーザー',
        'email' => 'updated@example.com'
    ]);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => '更新ユーザー',
        'email' => 'updated@example.com'
    ]);
});
