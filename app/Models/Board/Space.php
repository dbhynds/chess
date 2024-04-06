<?php

namespace App\Models\Board;

class Space
{
    public function __construct(private Row $row, private Column $column)
    {
    }

    public function row(): Row
    {
        return $this->row;
    }

    public function column(): Column
    {
        return $this->column;
    }

    public function name(): string
    {
        return self::named($this->row(), $this->column());
    }

    public static function named(Row $row, Column $column): string
    {
        return $row->value.$column->value;
    }
}
