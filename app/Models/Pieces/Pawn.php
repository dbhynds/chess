<?php

namespace App\Models\Pieces;

use App\Models\Game\Move\Direction;
use App\Models\Game\Move\Move;

class Pawn extends Piece
{
    public function name(): Pieces
    {
        return Pieces::Pawn;
    }

    public function possibleMoves(): array
    {
        return [
            // White
            Move::make($this)->withVector(-1, 1),
            Move::make($this)->withVector(0, 1),
            Move::make($this)->withVector(0, 2),
            Move::make($this)->withVector(1, 1),
            // Black
            Move::make($this)->withVector(-1, -1),
            Move::make($this)->withVector(0, -1),
            Move::make($this)->withVector(0, -2),
            Move::make($this)->withVector(1, -1),
        ];
    }

    public function moves(): array
    {
        $moves = $this->filteredMoves();

        return array_filter($moves, fn ($move) => $this->moveIsValidForThisColor($move));
    }

    public function moveIsValidForThisColor(Move $move): bool
    {
        return ($move->isDirection(Direction::Up) && $this->isWhite())
            || ($move->isDirection(Direction::Down) && $this->isBlack());
    }

    // @TODO: en passant
    // @TODO: promotion
}
