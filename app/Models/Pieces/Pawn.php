<?php

namespace App\Models\Pieces;

use App\Models\Board\Board;
use App\Models\Game\Move\Move;
use App\Models\Board\Space;

class Pawn extends Piece
{
    public function possibleMoves(): array
    {
        if ($this->isWhite()) {
            return [
                Move::make($this)->up(1),
                Move::make($this)->up(2),
                Move::make($this)->up(1)->left(1),
                Move::make($this)->up(1)->down(1),
            ];
        } else {
            return [
                Move::make($this)->down(1),
                Move::make($this)->down(2),
                Move::make($this)->down(1)->left(1),
                Move::make($this)->down(1)->down(1),
            ];
        }
    }
}
