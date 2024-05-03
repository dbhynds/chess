<?php

namespace App\Models\Players;

use App\Models\Game\Game;
use App\Models\Pieces\King;
use App\Models\Pieces\Pieces;
use App\Models\Traits\HasAColor;

class Player
{
    use HasAColor;

    public function __construct(private Color $color)
    {
    }

    public function king(): ?King
    {
        return app(Game::class)->activePieces()
            ->first(fn ($piece) => $piece->color() === $this->color && $piece->name() === Pieces::King);
    }
}
