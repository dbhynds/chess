<?php

namespace App\Models\Game;

use App\Models\Board\Board;
use App\Models\Board\Column;
use App\Models\Board\Row;
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

    public function __construct(private Board $board)
    {
        $this->white = new Player(Color::White);
        $this->black = new Player(Color::Black);
        $this->capturedPieces = collect([]);
        $this->activePieces = collect([]);
        $this->setActivePieces();
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
            new Rook(Color::White, $this->board()->space(Row::i1, Column::A)),
            new Knight(Color::White, $this->board()->space(Row::i1, Column::B)),
            new Bishop(Color::White, $this->board()->space(Row::i1, Column::C)),
            new Queen(Color::White, $this->board()->space(Row::i1, Column::D)),
            new King(Color::White, $this->board()->space(Row::i1, Column::E)),
            new Bishop(Color::White, $this->board()->space(Row::i1, Column::F)),
            new Knight(Color::White, $this->board()->space(Row::i1, Column::G)),
            new Rook(Color::White, $this->board()->space(Row::i1, Column::H)),
            new Pawn(Color::White, $this->board()->space(Row::i2, Column::A)),
            new Pawn(Color::White, $this->board()->space(Row::i2, Column::B)),
            new Pawn(Color::White, $this->board()->space(Row::i2, Column::C)),
            new Pawn(Color::White, $this->board()->space(Row::i2, Column::D)),
            new Pawn(Color::White, $this->board()->space(Row::i2, Column::E)),
            new Pawn(Color::White, $this->board()->space(Row::i2, Column::F)),
            new Pawn(Color::White, $this->board()->space(Row::i2, Column::G)),
            new Pawn(Color::White, $this->board()->space(Row::i2, Column::H)),
            // Black
            new Rook(Color::Black, $this->board()->space(Row::i8, Column::A)),
            new Knight(Color::Black, $this->board()->space(Row::i8, Column::B)),
            new Bishop(Color::Black, $this->board()->space(Row::i8, Column::C)),
            new Queen(Color::Black, $this->board()->space(Row::i8, Column::D)),
            new King(Color::Black, $this->board()->space(Row::i8, Column::E)),
            new Bishop(Color::Black, $this->board()->space(Row::i8, Column::F)),
            new Knight(Color::Black, $this->board()->space(Row::i8, Column::G)),
            new Rook(Color::Black, $this->board()->space(Row::i8, Column::H)),
            new Pawn(Color::Black, $this->board()->space(Row::i7, Column::A)),
            new Pawn(Color::Black, $this->board()->space(Row::i7, Column::B)),
            new Pawn(Color::Black, $this->board()->space(Row::i7, Column::C)),
            new Pawn(Color::Black, $this->board()->space(Row::i7, Column::D)),
            new Pawn(Color::Black, $this->board()->space(Row::i7, Column::E)),
            new Pawn(Color::Black, $this->board()->space(Row::i7, Column::F)),
            new Pawn(Color::Black, $this->board()->space(Row::i7, Column::G)),
            new Pawn(Color::Black, $this->board()->space(Row::i7, Column::H)),
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
}
