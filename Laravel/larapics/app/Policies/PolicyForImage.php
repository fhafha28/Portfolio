<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Image;
use App\Enums\Role;


class PolicyForImage
{

    public function update(User $user, Image $image ){
//        user 가져오는건 고정이고, 정책 적용할 모델도 넣어줘야 함.
        return $user->id===$image->user_id | $user->role=== Role::Editor;
    }

    public function delete(User $user, Image $image ){
        return $user->id===$image->user_id;
    }
}
