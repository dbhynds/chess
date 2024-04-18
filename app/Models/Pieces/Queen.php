<?php

namespace App\Models\Pieces;

use App\Models\Game\Move\Move;

class Queen extends Piece
{
    public function name(): Pieces
    {
        return Pieces::Queen;
    }

    public function possibleMoves(): array
    {
        $moves = [];

        foreach (range(-7, 7) as $coordinate) {
            if ($coordinate !== 0) {
                $moves[] = Move::make($this)->withVector($coordinate, $coordinate);
                $moves[] = Move::make($this)->withVector(-$coordinate, $coordinate);
                $moves[] = Move::make($this)->withVector(0, $coordinate);
                $moves[] = Move::make($this)->withVector($coordinate, 0);
            }
        }

        return $moves;
    }
}
