<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

uses(RefreshDatabase::class);

test('認証済みのユーザーが自分のプロファイル情報を取得できること', function () {
    $user = User::factory()->create([
        'name' => 'テストユーザー',
        'email' => 'test@example.com'
    ]);

    $response = $this->actingAs($user)->getJson('/api/profile');

    $response->assertStatus(200);

    expect($response['name'])->toBe('テストユーザー');
    expect($response['email'])->toBe('test@example.com');
});
