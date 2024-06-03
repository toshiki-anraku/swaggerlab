<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

uses(RefreshDatabase::class);

test('有効な資格情報でログインが成功すること', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $credentials = [
        'email' => $user->email,
        'password' => 'password',
    ];

    $response = $this->postJson(route('login'), $credentials);

    $response->assertOk();
    $response->assertJsonStructure(['token']);
});

test('無効な資格情報でログインが失敗すること', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $invalidCredentials = [
        'email' => $user->email,
        'password' => 'invalid-password',
    ];

    $response = $this->postJson(route('login'), $invalidCredentials);

    $response->assertUnauthorized();
    $response->assertJsonStructure(['message']);
});
