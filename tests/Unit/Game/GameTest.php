<?php

namespace Tests\Unit\Game;

use App\Models\Board\Board;
use App\Models\Board\Column;
use App\Models\Board\Row;
use App\Models\Board\Space;
use App\Models\Game\Game;
use App\Models\Game\Move\Move;
use App\Models\Players\Color;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function test_instantiates(): void
    {
        $game = app(Game::class);
        $this->assertInstanceOf(Game::class, $game);
    }

    public function test_board_returns_board(): void
    {
        $game = app(Game::class);

        $this->assertInstanceOf(Board::class, $game->board());
    }

    public function test_black_returns_black(): void
    {
        $game = app(Game::class);

        $this->assertEquals(Color::Black, $game->black()->color());
    }

    public function test_white_returns_white(): void
    {
        $game = app(Game::class);

        $this->assertEquals(Color::White, $game->white()->color());
    }

    public function test_players_returns_players(): void
    {
        $game = app(Game::class);

        $this->assertCount(2, $game->players());
    }

    public function test_pieces_returns_pieces(): void
    {
        $game = app(Game::class);

        $this->assertEquals(16, $game->pieces()->count());
    }

    public function test_move_moves_a_piece(): void
    {
        $game = app(Game::class);
        $piece = $game->pieces()->first();
        $oldSpace = $piece->space();
        $D4 = new Space(Column::D, Row::i4);
        $move = Move::make($piece)->to($D4);

        $game->make($move);

        $this->assertArrayNotHasKey($oldSpace->name(), $game->pieces());
        $this->assertEquals($piece, $game->pieces()[$D4->name()]);
    }
}
