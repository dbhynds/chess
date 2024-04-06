<?php

namespace App\Models\Pieces;

use App\Models\Board\Board;
use App\Models\Game\Move\Move;
use App\Models\Board\Space;

class Pawn extends Piece
{
    public function possibleMoves(): array
    {
        return [
            // White
            [-1, 1], [0, 1], [0, 2], [1, 1],
            // Black
            [-1, -1], [0, -1], [0, -2], [1, -1],
        ];
    }
}
