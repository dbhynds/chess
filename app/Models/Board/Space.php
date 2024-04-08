<?php

namespace App\Models\Board;

use App\Models\Game\Game;
use App\Models\Pieces\Piece;

class Space
{
    public function __construct(private Column $column, private Row $row)
    {
    }

    public function row(): Row
    {
        return $this->row;
    }

    public function rowPosition(): int
    {
        return array_search($this->row(), Board::rows());
    }

    public function column(): Column
    {
        return $this->column;
    }

    public function columnPosition(): int
    {
        return array_search($this->column(), Board::columns());
    }

    public static function named(Row $row, Column $column): string
    {
        return $column->value.$row->value;
    }

    public function name(): string
    {
        return self::named($this->row(), $this->column());
    }

    public function isOccupied(): bool
    {
        return app(Game::class)->hasAPieceOn($this);
    }

    public function piece(): Piece
    {
        return app(Game::class)->pieceOn($this);
    }
}
