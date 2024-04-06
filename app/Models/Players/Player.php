<?php

namespace App\Models\Players;

class Player
{
    public function __construct(private Color $color)
    {

    }

    public function color(): Color
    {
        return $this->color;
    }
}
