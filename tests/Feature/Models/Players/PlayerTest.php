<?php

namespace Tests\Feature\Models\Players;

use App\Models\Board\File;
use App\Models\Board\Rank;
use App\Models\Board\Space;
use App\Models\Game\Game;
use App\Models\Pieces\King;
use App\Models\Pieces\Pieces;
use App\Models\Players\Color;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    public function testKing(): void
    {
        $game = app(Game::class)->start();

        $this->assertEquals(Pieces::King, $game->white()->king()->name());
        $this->assertEquals(Color::White, $game->white()->king()->color());
        $this->assertEquals('e1', $game->white()->king()->space()->name());

        $this->assertEquals(Pieces::King, $game->black()->king()->name());
        $this->assertEquals(Color::Black, $game->black()->king()->color());
        $this->assertEquals('e8', $game->black()->king()->space()->name());

        $game->reset();
        $space = new Space(File::d, Rank::i4);
        $piece = new King(Color::White, $space);
        $game->place($piece);
        $this->assertEquals('d4', $game->white()->king()->space()->name());
    }
}
