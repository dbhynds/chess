<?php

namespace App\Models\Pieces;

use App\Models\Board\Space;
use App\Models\Players\Color;

abstract class Piece
{
    public function __construct(private Color $color, private Space $space)
    {
    }

    public function space(): Space
    {
        return $this->space;
    }

    public function color(): Color
    {
        return $this->color;
    }
}
