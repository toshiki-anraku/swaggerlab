<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('有効なデータでユーザー登録が成功すること', function () {
    $data = [
        'name' => '新しいユーザー',
        'email' => 'newuser@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ];

    $response = $this->postJson('/api/register', $data);

    $response->assertStatus(201);
    $response->assertJsonStructure(['token']);
    $this->assertDatabaseHas('users', ['email' => 'newuser@example.com']);
});

test('無効なデータでユーザー登録が失敗すること', function () {
    $data = [
        'name' => '',
        'email' => 'notanemail',
        'password' => 'pass',
        'password_confirmation' => 'password'
    ];

    $response = $this->postJson('/api/register', $data);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['name', 'email', 'password']);
});
