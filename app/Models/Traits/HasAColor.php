<?php

namespace App\Models\Traits;

use App\Models\Players\Color;

trait HasAColor
{
    public function color(): Color
    {
        return $this->color;
    }

    public function isBlack(): bool
    {
        return $this->color() === Color::Black;
    }

    public function isWhite(): bool
    {
        return $this->color() === Color::White;
    }
}
