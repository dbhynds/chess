<?php

namespace Tests\Unit\Board;

use App\Models\Board\Board;
use App\Models\Board\Space;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    public function test_board_instantiates(): void
    {
        $board = app(Board::class);
        $this->assertInstanceOf(Board::class, $board);
    }

    public function test_returns_spaces(): void
    {
        $board = app(Board::class);

        $this->assertEquals(64, $board->spaces()->count());
        $this->assertInstanceOf(Space::class, $board->spaces()['A1']);
    }
}
