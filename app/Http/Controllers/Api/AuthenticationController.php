<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

/**
 * 認証に関する処理を扱うコントローラーです。
 */
class AuthenticationController extends Controller
{
    /**
     * コンストラクタ
     *
     * @param UserService $userService
     */
    public function __construct(
        protected UserService $userService
    ){}

    /**
     * ユーザー登録を行います。
     *
     * @param RegisterRequest $request 登録情報が含まれたリクエスト
     * @return JsonResponse 新規ユーザーの情報とトークンを返します。
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->userService->registerUser($request->validated());
        return response()->json(['user' => new UserResource($result['user']), 'token' => $result['token']], 201);
    }

    /**
     * ユーザー認証（ログイン）を行います。
     *
     * @param LoginRequest $request ログイン情報が含まれたリクエスト
     * @return JsonResponse ユーザー情報とトークン、または認証失敗のメッセージを返します。
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->userService->authenticateUser($request->validated());
        if (!$result) {
            return response()->json(['message' => '認証に失敗しました。'], 401);
        }
        return response()->json(['user' => new UserResource($result['user']), 'token' => $result['token']]);
    }
}
