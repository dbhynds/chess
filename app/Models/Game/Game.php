<?php

namespace App\Models\Game;

use App\Models\Board\Board;
use App\Models\Board\Column;
use App\Models\Board\Row;
use App\Models\Board\Space;
use App\Models\Game\Move\Move;
use App\Models\Pieces\Pawn;
use App\Models\Pieces\Piece;
use App\Models\Players\Color;
use App\Models\Players\Player;
use Illuminate\Support\Collection;

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
        $this->activePieces = $this->setActivePieces();
        $this->capturedPieces = collect([]);
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

    private function setActivePieces(): Collection
    {
        $startingConfiguration = [
            // White
            new Pawn(Color::White, $this->board->space(Row::i2, Column::A)),
            new Pawn(Color::White, $this->board->space(Row::i2, Column::B)),
            new Pawn(Color::White, $this->board->space(Row::i2, Column::C)),
            new Pawn(Color::White, $this->board->space(Row::i2, Column::D)),
            new Pawn(Color::White, $this->board->space(Row::i2, Column::E)),
            new Pawn(Color::White, $this->board->space(Row::i2, Column::F)),
            new Pawn(Color::White, $this->board->space(Row::i2, Column::G)),
            new Pawn(Color::White, $this->board->space(Row::i2, Column::H)),
            // Black
            new Pawn(Color::Black, $this->board->space(Row::i7, Column::A)),
            new Pawn(Color::Black, $this->board->space(Row::i7, Column::B)),
            new Pawn(Color::Black, $this->board->space(Row::i7, Column::C)),
            new Pawn(Color::Black, $this->board->space(Row::i7, Column::D)),
            new Pawn(Color::Black, $this->board->space(Row::i7, Column::E)),
            new Pawn(Color::Black, $this->board->space(Row::i7, Column::F)),
            new Pawn(Color::Black, $this->board->space(Row::i7, Column::G)),
            new Pawn(Color::Black, $this->board->space(Row::i7, Column::H)),
        ];

        $pieces = [];
        foreach ($startingConfiguration as $piece) {
            $pieces[$piece->space()->name()] = $piece;
        }

        return collect($pieces);
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

        if (! $piece->can($move)) {
            throw \Exception('That move is not allowed.');
        }

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
