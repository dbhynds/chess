<?php

namespace App\Models\Pieces;

use App\Models\Board\Space;
use App\Models\Players\Color;
use App\Models\Traits\HasAColor;

abstract class Piece
{
    use HasAColor;

    public function __construct(private Color $color, private Space $space)
    {
    }

    public function space(): Space
    {
        return $this->space;
    }

    public function requiresAClearPath(): bool
    {
        return true;
    }

    abstract public function possibleMoves(): array;
}
