<?php

namespace App\Models\Pieces;

use App\Models\Game\Move\Move;

class Knight extends Piece
{
    public function name(): Pieces
    {
        return Pieces::Knight;
    }

    public function requiresAClearPath(): bool
    {
        return false;
    }

    public function possibleMoves(): array
    {
        return [
            Move::make($this)->withVector(2, 3),
            Move::make($this)->withVector(3, 2),
            Move::make($this)->withVector(2, -3),
            Move::make($this)->withVector(3, -2),
            Move::make($this)->withVector(-2, -3),
            Move::make($this)->withVector(-3, -2),
            Move::make($this)->withVector(-2, 3),
            Move::make($this)->withVector(-3, 2),
        ];
    }
}
