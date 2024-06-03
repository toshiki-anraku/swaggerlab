<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserRepositoryInterface;

/**
 * ユーザーに関連するビジネスロジックを管理するサービスクラスです。
 */
class UserService
{
    /**
     * コンストラクタ
     *
     * @param UserRepositoryInterface $userRepository ユーザーリポジトリのインスタンス
     */
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ){}

    /**
     * ユーザーを登録し、トークンを生成します。
     *
     * @param array $data ユーザー登録データ
     * @return array 登録されたユーザーとトークンを含む配列
     */
    public function registerUser(array $data): array
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepository->create($data);
        $token = $user->createToken('auth_token')->plainTextToken;
        return ['user' => $user, 'token' => $token];
    }

    /**
     * ユーザー認証を試み、成功した場合はトークンを生成します。
     *
     * @param array $credentials 認証データ（メールアドレスとパスワード）
     * @return array|null 認証成功時はユーザーとトークンを含む配列、失敗時はnull
     */
    public function authenticateUser(array $credentials): ?array
    {
        if (!Auth::attempt($credentials)) {
            return null;
        }

        $user = Auth::user();
        if ($user instanceof User) {
            $token = $user->createToken('auth_token')->plainTextToken;
        }

        return ['user' => $user, 'token' => $token];
    }

    /**
     * 指定されたユーザーIDのユーザー情報を更新します。
     *
     * @param int $userId ユーザーID
     * @param array $data 更新データ
     * @return User 更新されたユーザー
     */
    public function updateUser(int $userId, array $data)
    {
        $user = $this->userRepository->findById($userId);
        if (!$user) {
            throw new \Exception("User not found.");
        }
        $user->update($data);
        return $user;
    }
}
