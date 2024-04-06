<?php

namespace App\Models\Pieces;

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
