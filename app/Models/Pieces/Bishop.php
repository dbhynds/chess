<?php

namespace App\Models\Pieces;

use App\Models\Game\Move\Direction;
use App\Models\Game\Move\Move;

class Bishop extends Piece
{
    public function name(): Pieces
    {
        return Pieces::Bishop;
    }

    public function possibleMoves(): array
    {
        $moves = [];

        foreach (range(-7, 7) as $coordinate) {
            if ($coordinate !== 0) {
                $moves[] = Move::make($this)->withVector($coordinate, $coordinate);
                $moves[] = Move::make($this)->withVector(-$coordinate, $coordinate);
            }
        }

        return $moves;
    }
}
