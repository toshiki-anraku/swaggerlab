<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

/**
 * ユーザー関連の操作を扱うコントローラーです。
 */
class UserController extends Controller
{
    /**
     * 新しいユーザーを登録します。
     *
     * @param  RegisterRequest  $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->validated()['name'],
            'email' => $request->validated()['email'],
            'password' => Hash::make($request->validated()['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['user' => new UserResource($user), 'token' => $token], 201);
    }

    /**
     * ユーザーがログインします。
     *
     * @param  LoginRequest  $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->validated())) {
            return response()->json(['message' => '認証に失敗しました。'], 401);
        }

        $user = Auth::user();
        if ($user instanceof User) {
            $token = $user->createToken('auth_token')->plainTextToken;
        }

        return response()->json(['user' => new UserResource($user), 'token' => $token]);
    }

    /**
     * 現在認証されているユーザーの情報を取得します。
     *
     * @return JsonResponse
     */
    public function profile(): JsonResponse
    {
        return response()->json(new UserResource(Auth::user()));
    }

    /**
     * ユーザー情報を更新します。
     *
     * @param  UpdateUserRequest  $request
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request): JsonResponse
    {
        $user = Auth::user();
        if ($user instanceof User) {
            $user->update($request->validated());
        }

        return response()->json(new UserResource($user));
    }
}
