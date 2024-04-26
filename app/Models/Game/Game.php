<?php

namespace App\Models\Game;

use App\Models\Board\Board;
use App\Models\Board\File;
use App\Models\Board\Rank;
use App\Models\Board\Space;
use App\Models\Game\Move\Move;
use App\Models\Pieces\Bishop;
use App\Models\Pieces\King;
use App\Models\Pieces\Knight;
use App\Models\Pieces\Pawn;
use App\Models\Pieces\Piece;
use App\Models\Pieces\Queen;
use App\Models\Pieces\Rook;
use App\Models\Players\Color;
use App\Models\Players\Player;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;

class Game
{
    private Collection $activePieces;

    private Collection $capturedPieces;

    private Player $white;

    private Player $black;

    private Player $currentTurn;

    public function __construct(private Board $board)
    {
        $this->white = new Player(Color::White);
        $this->black = new Player(Color::Black);
        $this->capturedPieces = collect([]);
        $this->activePieces = collect([]);
    }

    public function reset(): self
    {
        $this->capturedPieces = collect([]);
        $this->activePieces = collect([]);

        return $this;
    }

    public function start(): self
    {
        $this->reset()->setActivePieces();
        $this->currentTurn = $this->white();

        return $this;
    }

    public function board(): Board
    {
        return $this->board;
    }

    public function white(): Player
    {
        return $this->white;
    }

    public function black(): Player
    {
        return $this->black;
    }

    public function currentTurn(): Player
    {
        return $this->currentTurn;
    }

    /**
     * @return array<Player>
     */
    public function players(): array
    {
        return [$this->white(), $this->black()];
    }

    public function activePieces(): Collection
    {
        return $this->activePieces;
    }

    public function capturedPieces(): Collection
    {
        return $this->capturedPieces;
    }

    public function place(Piece $piece): void
    {
        $this->activePieces->put($piece->space()->name(), $piece);
    }

    private function setActivePieces(): void
    {
        $startingConfiguration = [
            // White
            new Rook(Color::White, $this->board()->space(Rank::i1, File::a)),
            new Knight(Color::White, $this->board()->space(Rank::i1, File::b)),
            new Bishop(Color::White, $this->board()->space(Rank::i1, File::c)),
            new Queen(Color::White, $this->board()->space(Rank::i1, File::d)),
            new King(Color::White, $this->board()->space(Rank::i1, File::e)),
            new Bishop(Color::White, $this->board()->space(Rank::i1, File::f)),
            new Knight(Color::White, $this->board()->space(Rank::i1, File::g)),
            new Rook(Color::White, $this->board()->space(Rank::i1, File::h)),
            new Pawn(Color::White, $this->board()->space(Rank::i2, File::a)),
            new Pawn(Color::White, $this->board()->space(Rank::i2, File::b)),
            new Pawn(Color::White, $this->board()->space(Rank::i2, File::c)),
            new Pawn(Color::White, $this->board()->space(Rank::i2, File::d)),
            new Pawn(Color::White, $this->board()->space(Rank::i2, File::e)),
            new Pawn(Color::White, $this->board()->space(Rank::i2, File::f)),
            new Pawn(Color::White, $this->board()->space(Rank::i2, File::g)),
            new Pawn(Color::White, $this->board()->space(Rank::i2, File::h)),
            // Black
            new Rook(Color::Black, $this->board()->space(Rank::i8, File::a)),
            new Knight(Color::Black, $this->board()->space(Rank::i8, File::b)),
            new Bishop(Color::Black, $this->board()->space(Rank::i8, File::c)),
            new Queen(Color::Black, $this->board()->space(Rank::i8, File::d)),
            new King(Color::Black, $this->board()->space(Rank::i8, File::e)),
            new Bishop(Color::Black, $this->board()->space(Rank::i8, File::f)),
            new Knight(Color::Black, $this->board()->space(Rank::i8, File::g)),
            new Rook(Color::Black, $this->board()->space(Rank::i8, File::h)),
            new Pawn(Color::Black, $this->board()->space(Rank::i7, File::a)),
            new Pawn(Color::Black, $this->board()->space(Rank::i7, File::b)),
            new Pawn(Color::Black, $this->board()->space(Rank::i7, File::c)),
            new Pawn(Color::Black, $this->board()->space(Rank::i7, File::d)),
            new Pawn(Color::Black, $this->board()->space(Rank::i7, File::e)),
            new Pawn(Color::Black, $this->board()->space(Rank::i7, File::f)),
            new Pawn(Color::Black, $this->board()->space(Rank::i7, File::g)),
            new Pawn(Color::Black, $this->board()->space(Rank::i7, File::h)),
        ];

        foreach ($startingConfiguration as $piece) {
            $this->place($piece);
        }
    }

    public function removeFromTheBoard(Space $space, Piece $piece): self
    {
        $this->activePieces->forget($space->name());
        $this->capturedPieces->push($piece);

        return $this;
    }

    public function make(Move $move): self
    {
        $piece = $move->piece();

        Gate::authorize('can', $move);

        if ($move->capturesAPiece()) {
            $move->capturedPiece()->capture();
        }

        // Move
        $this->activePieces->forget($move->originalSpace()->name());
        $piece->setSpace($move->newSpace());
        $this->activePieces->put($piece->space()->name(), $piece);

        return $this;
    }

    public function hasAPieceOn(Space $space): bool
    {
        return $this->activePieces()->has($space->name());
    }

    public function pieceOn(Space $space): Piece
    {
        return $this->activePieces()->get($space->name());
    }

    public function dump(): void
    {
        $pieces = [];
        $this->activePieces()->each(function ($piece) use (&$pieces) {
            $pieces[] = implode([
                $piece->color()->value,
                $piece->name()->value,
                $piece->space()->name(),
            ]);
        });

        dump(implode(' ', $pieces));
    }
}
