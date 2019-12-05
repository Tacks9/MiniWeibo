<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Status;

class StatusPolicy
{
    use HandlesAuthorization;

    // 删除策略
    public function destroy(User $user, Status $status)
    {
        return $user->id === $status->user_id;
    }
}
