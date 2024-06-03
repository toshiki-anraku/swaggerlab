<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * ユーザープロファイルに関する処理を扱うコントローラーです。
 */
class UserProfileController extends Controller
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
     * 現在認証されているユーザーのプロファイルを取得します。
     *
     * @return JsonResponse 認証済みユーザーの情報を返します。
     */
    public function profile(): JsonResponse
    {
        return response()->json(new UserResource(Auth::user()));
    }

    /**
     * ユーザー情報の更新を行います。
     *
     * @param UpdateUserRequest $request 更新情報が含まれたリクエスト
     * @return JsonResponse 更新後のユーザー情報を返します。
     */
    public function update(UpdateUserRequest $request): JsonResponse
    {
        $user = $this->userService->updateUser(Auth::id(), $request->validated());
        return response()->json(new UserResource($user));
    }
}
