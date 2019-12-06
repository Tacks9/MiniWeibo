<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //更新用户的  授权策略
    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }

    // 删除用户
    public function destroy(User $currentUser, User $user)
    {
        // 只有当前登录用户为管理员才能执行删除操作
        // 删除的用户对象不是自己
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }

    // 关注策略
    public function follow(User $currentUser, User $user)
    {
        // 自己不能关注自己
        return $currentUser->id !== $user->id;
    }


}
