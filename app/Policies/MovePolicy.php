<?php

namespace App\Policies;

use App\Models\Game\Game;
use App\Models\Game\Move\Move;
use App\Models\Pieces\Pieces;
use App\Models\User;

class MovePolicy
{
    public function can(?User $user, Move $move): bool
    {
        // @todo prevent if king in check and it doesn't block
        // @todo prevent if move puts king in check
        // @todo prevent if special move (castling, en passant) is prohibited
        return $this->movePieceToSpace($user, $move)
            && $this->travelToTheNewSpace($user, $move)
            && $this->occupyTheNewSpace($user, $move)
            && $this->leavesTheKingWithoutCheck($user, $move);
    }

    public function movePieceToSpace(?User $user, Move $move): bool
    {
        return array_reduce(
            $move->piece()->moves(),
            fn (bool $carry, Move $possibleMove) => $carry || $possibleMove->newSpace()->name() === $move->newSpace()->name(),
            false
        );
    }

    public function travelToTheNewSpace(?User $user, Move $move): bool
    {
        return ! $move->piece()->requiresAClearPath() || ! $move->isObstructed();
    }

    public function occupyTheNewSpace(?User $user, Move $move): bool
    {
        // @todo check pawns
        return ! $move->newSpace()->isOccupied() || $move->capturesAPiece();
    }

    public function leavesTheKingWithoutCheck(?User $user, Move $move): bool
    {
        // Find where the moving player's king is
        $kingSpace = app(Game::class)
            ->activePieces()
            ->first(fn ($piece) => $piece->color() === $move->piece()->color()
                && $piece->name() === Pieces::King
            )->space();

        // See if any of the opposing pieces can capture it
        return app(Game::class)
            ->activePieces()
            // Filter to opposing pieces
            ->filter(fn ($piece) => $piece->color() !== $move->piece()->color())
            ->reduce(function ($carry, $piece) use ($kingSpace, $user, $move) {
                // Hypothical next move to capture the king
                $nextMove = Move::make($piece)->to($kingSpace);

                return $carry
                    || ! (
                        // The piece can be blocked
                        $piece->requiresAClearPath()
                           // The move doesn't capture this piece
                           && (! $move->capturesAPiece() || $move->capturedPiece() !== $piece)
                           // The move is in the piece's possible moves
                           && $this->movePieceToSpace($user, $nextMove)
                           // The piece isn't blocked if moving to the new space
                           && $nextMove->isObstructed($move)
                    );
            }, false);
    }
}
