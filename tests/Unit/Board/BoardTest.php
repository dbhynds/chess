<?php

namespace Tests\Unit\Board;

use App\Models\Board\Board;
use App\Models\Board\Column;
use App\Models\Board\Row;
use App\Models\Board\Space;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    public function testBoardInstantiates(): void
    {
        $board = app(Board::class);
        $this->assertInstanceOf(Board::class, $board);
    }

    public function testSpacesReturnsSpaces(): void
    {
        $board = app(Board::class);

        $this->assertEquals(64, $board->spaces()->count());
    }

    public function testSpaceReturnsASpace(): void
    {
        $board = app(Board::class);

        $space = $board->space(Row::i1, Column::A);

        $this->assertInstanceOf(Space::class, $space);
        $this->assertEquals('A1', $space->name());
    }
}
