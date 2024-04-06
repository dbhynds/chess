<?php

namespace Tests\Unit\Board;

use App\Models\Board\Board;
use App\Models\Board\Column;
use App\Models\Board\Row;
use App\Models\Board\Space;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    public function test_board_instantiates(): void
    {
        $board = app(Board::class);
        $this->assertInstanceOf(Board::class, $board);
    }

    public function test_spaces_returns_spaces(): void
    {
        $board = app(Board::class);

        $this->assertEquals(64, $board->spaces()->count());
    }

    public function test_space_returns_a_space(): void
    {
        $board = app(Board::class);

        $space = $board->space(Row::A, Column::i1);

        $this->assertInstanceOf(Space::class, $space);
        $this->assertEquals('A1', $space->name());
    }
}
