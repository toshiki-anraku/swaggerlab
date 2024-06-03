<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Models\User;

/**
 * ユーザー関連のデータ操作を抽象化するインターフェースです。
 */
interface UserRepositoryInterface
{
    /**
     * 新しいユーザーを属性の配列を使用して作成します。
     *
     * @param array $attributes ユーザーを作成するための属性
     * @return User 作成されたユーザーのエンティティ
     */
    public function create(array $attributes): User;

    /**
     * メールアドレスに基づいてユーザーを検索します。
     *
     * @param string $email 検索するユーザーのメールアドレス
     * @return User|null メールアドレスにマッチするユーザー、存在しない場合はnull
     */
    public function findByEmail(string $email): ?User;

    /**
     * ユーザーIDに基づいてユーザーを検索します。
     *
     * @param int $id 検索するユーザーのID
     * @return User|null IDにマッチするユーザー、存在しない場合はnull
     */
    public function findById(int $id): ?User;

    /**
     * 指定されたユーザーの属性を更新します。
     *
     * @param User $user 更新を行うユーザーのエンティティ
     * @param array $attributes 更新する属性の配列
     * @return User 更新されたユーザーのエンティティ
     */
    public function update(User $user, array $attributes): User;
}
