<?php

namespace App\Models\Pieces;

use App\Models\Board\File;
use App\Models\Board\Rank;
use App\Models\Board\Space;
use App\Models\Game\Game;
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

    public function isInCheckAfter(?Move $move): bool
    {
        app(Game::class)->dump();

        return app(Game::class)
            ->activePieces()
            // Filter to opposing pieces
            ->filter(fn ($piece) => $piece->color() !== $this->color())
            ->reduce(function ($carry, $piece) use ($move) {
                // Hypothical next move to capture the king
                $nextMove = Move::make($piece)->to($this->space());
                $move->dump();
                $nextMove->dump();

                dump(
                    $piece->requiresAClearPath(),
                    // The move doesn't capture this piece
                    (! $move->capturesAPiece() || $move->capturedPiece() !== $piece),
                    // The move is in the piece's possible moves
                    $nextMove->belongsToThePiece(),
                    // The piece isn't blocked if moving to the new space
                    ! $nextMove->isObstructed($move)
                );

                return $carry
                    || ! (
                        // The piece can be blocked
                        $piece->requiresAClearPath()
                           // The move doesn't capture this piece
                           && (! $move->capturesAPiece() || $move->capturedPiece() !== $piece)
                           // The move is in the piece's possible moves
                           && $nextMove->belongsToThePiece()
                           // The piece isn't blocked if moving to the new space
                           && ! $nextMove->isObstructed($move)
                    );
            }, false);
    }
}
