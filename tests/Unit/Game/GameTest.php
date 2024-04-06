<?php

namespace Tests\Unit\Game;

use App\Models\Board\Board;
use App\Models\Game\Game;
use App\Models\Players\Color;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function test_instantiates(): void
    {
        $game = app(Game::class);
        $this->assertInstanceOf(Game::class, $game);
    }

    public function test_returns_board(): void
    {
        $game = app(Game::class);

        $this->assertInstanceOf(Board::class, $game->board());
    }

    public function test_returns_black(): void
    {
        $game = app(Game::class);

        $this->assertEquals(Color::Black, $game->black()->color());
    }

    public function test_returns_white(): void
    {
        $game = app(Game::class);

        $this->assertEquals(Color::White, $game->white()->color());
    }

    public function test_returns_players(): void
    {
        $game = app(Game::class);

        $this->assertCount(2, $game->players());
    }

    public function test_returns_pieces(): void
    {
        $game = app(Game::class);

        $this->assertEquals(16, $game->pieces()->count());
    }
}
