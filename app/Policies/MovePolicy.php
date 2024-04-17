<?php

namespace App\Policies;

use App\Models\Game\Move\Move;
use App\Models\User;

class MovePolicy
{
    public function can(?User $user, Move $move)
    {
        return $this->travelToTheNewSpace($user, $move)
            && $this->occupyTheNewSpace($user, $move);
    }

    public function travelToTheNewSpace(?User $user, Move $move)
    {
        return !$move->piece()->requiresAClearPath() || !$move->isObstructed();
    }

    public function occupyTheNewSpace(?User $user, Move $move)
    {
        return !$move->newSpace()->isOccupied() || $move->capturesAPiece();
    }
}
