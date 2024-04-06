<?php

namespace App\Models\Game;

use App\Models\Board\Board;
use App\Models\Board\Column;
use App\Models\Board\Row;
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
                'space' => $this->board->space(Row::B, Column::i1),
                'piece' => Pawn::class,
                'color' => Color::White,
            ],
            [
                'space' => $this->board->space(Row::B, Column::i2),
                'piece' => Pawn::class,
                'color' => Color::White,
            ],
            [
                'space' => $this->board->space(Row::B, Column::i3),
                'piece' => Pawn::class,
                'color' => Color::White,
            ],
            [
                'space' => $this->board->space(Row::B, Column::i4),
                'piece' => Pawn::class,
                'color' => Color::White,
            ],
            [
                'space' => $this->board->space(Row::B, Column::i5),
                'piece' => Pawn::class,
                'color' => Color::White,
            ],
            [
                'space' => $this->board->space(Row::B, Column::i6),
                'piece' => Pawn::class,
                'color' => Color::White,
            ],
            [
                'space' => $this->board->space(Row::B, Column::i7),
                'piece' => Pawn::class,
                'color' => Color::White,
            ],
            [
                'space' => $this->board->space(Row::B, Column::i8),
                'piece' => Pawn::class,
                'color' => Color::White,
            ],
            [
                'space' => $this->board->space(Row::G, Column::i1),
                'piece' => Pawn::class,
                'color' => Color::Black,
            ],
            [
                'space' => $this->board->space(Row::G, Column::i2),
                'piece' => Pawn::class,
                'color' => Color::Black,
            ],
            [
                'space' => $this->board->space(Row::G, Column::i3),
                'piece' => Pawn::class,
                'color' => Color::Black,
            ],
            [
                'space' => $this->board->space(Row::G, Column::i4),
                'piece' => Pawn::class,
                'color' => Color::Black,
            ],
            [
                'space' => $this->board->space(Row::G, Column::i5),
                'piece' => Pawn::class,
                'color' => Color::Black,
            ],
            [
                'space' => $this->board->space(Row::G, Column::i6),
                'piece' => Pawn::class,
                'color' => Color::Black,
            ],
            [
                'space' => $this->board->space(Row::G, Column::i7),
                'piece' => Pawn::class,
                'color' => Color::Black,
            ],
            [
                'space' => $this->board->space(Row::G, Column::i8),
                'piece' => Pawn::class,
                'color' => Color::Black,
            ],
        ];

        $pieces = [];
        foreach ($startingConfiguration as $piece) {
            $pieces[] = new $piece['piece']($piece['color'], $piece['space']);
        }

        return collect($pieces);
    }
}
