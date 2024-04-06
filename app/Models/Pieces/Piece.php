<?php

namespace App\Models\Pieces;

use App\Models\Board\Space;
use App\Models\Players\Color;

abstract class Piece
{
    public function __construct(private Color $color, private Space $space)
    {
    }

    public function isOn(Space $space): bool
    {
        return $space->name() === $this->space->name();
    }

    public function color(): Color
    {
        return $this->color;
    }
}
