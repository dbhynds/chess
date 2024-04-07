<?php

namespace App\Models\Board;

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
}
