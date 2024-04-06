<?php

namespace App\Models\Players;

use App\Models\Traits\HasAColor;

class Player
{
    use HasAColor;

    public function __construct(private Color $color)
    {

    }
}
