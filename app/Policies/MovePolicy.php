<?php

namespace App\Policies;

use App\Models\Game\Move\Move;
use App\Models\User;

class MovePolicy
{
    public function can(?User $user, Move $move)
    {
        return true;
    }
}
