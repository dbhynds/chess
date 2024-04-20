<?php

namespace App\Models\Pieces;

use App\Models\Board\File;
use App\Models\Board\Rank;
use App\Models\Board\Space;
use App\Models\Game\Move\Move;

class King extends Piece
{
    public function name(): Pieces
    {
        return Pieces::King;
    }

    public function possibleMoves(): array
    {
        return [
            // Regular moves
            Move::make($this)->withVector(1, 1),
            Move::make($this)->withVector(1, 1),
            Move::make($this)->withVector(1, -1),
            Move::make($this)->withVector(1, -1),
            Move::make($this)->withVector(-1, -1),
            Move::make($this)->withVector(-1, -1),
            Move::make($this)->withVector(-1, 1),
            Move::make($this)->withVector(-1, 1),
            // Castle moves
            Move::make($this)->to(new Space(File::c, Rank::i1)),
            Move::make($this)->to(new Space(File::g, Rank::i1)),
            Move::make($this)->to(new Space(File::c, Rank::i8)),
            Move::make($this)->to(new Space(File::g, Rank::i8)),
        ];
    }

    public function moves(): array
    {
        // @todo test
        $moves = $this->filteredMoves();

        return array_filter($moves, fn ($move) => ! $move->isCastling() || $this->canCastle());
    }

    public function canCastle(): bool
    {
        // @todo test
        // @todo check game history, check, and if king or rook space can be captured
        return true;
    }
}
