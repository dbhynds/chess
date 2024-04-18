<?php

namespace App\Models\Pieces;

use App\Models\Game\Move\Move;

class Rook extends Piece
{
    public function name(): Pieces
    {
        return Pieces::Rook;
    }

    public function possibleMoves(): array
    {
        $moves = [];

        foreach (range(-7, 7) as $coordinate) {
            if ($coordinate !== 0) {
                $moves[] = Move::make($this)->withVector(0, $coordinate);
                $moves[] = Move::make($this)->withVector($coordinate, 0);
            }
        }

        return $moves;
    }

    // @todo prevent castling if moved
}
