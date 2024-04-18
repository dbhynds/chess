<?php

namespace App\Policies;

use App\Models\Game\Move\Move;
use App\Models\User;

class MovePolicy
{
    public function can(?User $user, Move $move): bool
    {
        return $this->movePieceToSpace($user, $move)
            && $this->travelToTheNewSpace($user, $move)
            && $this->occupyTheNewSpace($user, $move);
    }

    public function movePieceToSpace(?User $user, Move $move): bool
    {
        return array_reduce(
            $move->piece()->moves(),
            fn (bool $carry, Move $possibleMove) => $carry || $possibleMove->newSpace()->name() === $move->newSpace()->name(),
            false
        );
    }

    public function travelToTheNewSpace(?User $user, Move $move): bool
    {
        return ! $move->piece()->requiresAClearPath() || ! $move->isObstructed();
    }

    public function occupyTheNewSpace(?User $user, Move $move): bool
    {
        return ! $move->newSpace()->isOccupied() || $move->capturesAPiece();
    }
}
