<?php

namespace App\Models\Board;

class Space
{
    public function __construct(private string $row, private int $column)
    {
    }

    public function row(): string
    {
        return $this->row;
    }

    public function column(): string
    {
        return $this->column;
    }

    public function name(): string
    {
        return $this->row().$this->column();
    }
}
