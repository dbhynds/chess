<?php

namespace App\Models\Game;

use App\Models\Board\Board;
use App\Models\Board\Column;
use App\Models\Board\Row;
use App\Models\Game\Move\Move;
use App\Models\Pieces\Pawn;
use App\Models\Players\Color;
use App\Models\Players\Player;
use Illuminate\Support\Collection;

class Game
{
    private Collection $pieces;

    private Player $white;

    private Player $black;

    public function __construct(private Board $board)
    {
        $this->white = new Player(Color::White);
        $this->black = new Player(Color::Black);
        $this->pieces = $this->setPieces();
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

    public function pieces(): Collection
    {
        return $this->pieces;
    }

    private function setPieces(): Collection
    {
        $startingConfiguration = [
            [
                'space' => $this->board->space(Row::i2, Column::A),
                'piece' => Pawn::class,
                'color' => Color::White,
            ],
            [
                'space' => $this->board->space(Row::i2, Column::B),
                'piece' => Pawn::class,
                'color' => Color::White,
            ],
            [
                'space' => $this->board->space(Row::i2, Column::C),
                'piece' => Pawn::class,
                'color' => Color::White,
            ],
            [
                'space' => $this->board->space(Row::i2, Column::D),
                'piece' => Pawn::class,
                'color' => Color::White,
            ],
            [
                'space' => $this->board->space(Row::i2, Column::E),
                'piece' => Pawn::class,
                'color' => Color::White,
            ],
            [
                'space' => $this->board->space(Row::i2, Column::F),
                'piece' => Pawn::class,
                'color' => Color::White,
            ],
            [
                'space' => $this->board->space(Row::i2, Column::G),
                'piece' => Pawn::class,
                'color' => Color::White,
            ],
            [
                'space' => $this->board->space(Row::i2, Column::H),
                'piece' => Pawn::class,
                'color' => Color::White,
            ],
            [
                'space' => $this->board->space(Row::i7, Column::A),
                'piece' => Pawn::class,
                'color' => Color::Black,
            ],
            [
                'space' => $this->board->space(Row::i7, Column::B),
                'piece' => Pawn::class,
                'color' => Color::Black,
            ],
            [
                'space' => $this->board->space(Row::i7, Column::C),
                'piece' => Pawn::class,
                'color' => Color::Black,
            ],
            [
                'space' => $this->board->space(Row::i7, Column::D),
                'piece' => Pawn::class,
                'color' => Color::Black,
            ],
            [
                'space' => $this->board->space(Row::i7, Column::E),
                'piece' => Pawn::class,
                'color' => Color::Black,
            ],
            [
                'space' => $this->board->space(Row::i7, Column::F),
                'piece' => Pawn::class,
                'color' => Color::Black,
            ],
            [
                'space' => $this->board->space(Row::i7, Column::G),
                'piece' => Pawn::class,
                'color' => Color::Black,
            ],
            [
                'space' => $this->board->space(Row::i7, Column::H),
                'piece' => Pawn::class,
                'color' => Color::Black,
            ],
        ];

        $pieces = [];
        foreach ($startingConfiguration as $piece) {
            $pieces[$piece['space']->name()] = new $piece['piece']($piece['color'], $piece['space']);
        }

        return collect($pieces);
    }

    public function make(Move $move)
    {
        $piece = $move->piece();

        if (! $piece->can($move)) {
            throw \Exception('That move is not allowed.');
        }

        // if ($move->capturesAPiece()) {
        //     $piece = $move->capturedPiece();
        // }

        // Move
        $this->pieces->forget($move->originalSpace()->name());
        $piece->setSpace($move->newSpace());
        $this->pieces->put($piece->space()->name(), $piece);
    }
}
