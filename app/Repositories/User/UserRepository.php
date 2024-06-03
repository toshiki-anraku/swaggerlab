<?php
declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User;

/**
 * ユーザーデータにアクセスするためのリポジトリクラスです。
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * 新しいユーザーを作成します。
     *
     * @param array $attributes ユーザーを作成するための属性配列
     * @return User 作成されたユーザーのインスタンス
     */
    public function create(array $attributes): User
    {
        return User::create($attributes);
    }

    /**
     * メールアドレスによるユーザー検索を行います。
     *
     * @param string $email 検索するユーザーのメールアドレス
     * @return User|null 見つかったユーザー、もしくは見つからなかった場合はnull
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * ユーザーIDによるユーザー検索を行います。
     *
     * @param int $id 検索するユーザーのID
     * @return User|null 見つかったユーザー、もしくは見つからなかった場合はnull
     */
    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * 既存のユーザー情報を更新します。
     *
     * @param User $user 更新するユーザーのインスタンス
     * @param array $attributes 更新する属性の配列
     * @return User 更新後のユーザーのインスタンス
     */
    public function update(User $user, array $attributes): User
    {
        $user->update($attributes);
        return $user;
    }
}
