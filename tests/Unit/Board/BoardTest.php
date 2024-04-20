<?php

namespace Tests\Unit\Board;

use App\Models\Board\Board;
use App\Models\Board\File;
use App\Models\Board\Rank;
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

        $space = $board->space(Rank::i1, File::a);

        $this->assertInstanceOf(Space::class, $space);
        $this->assertEquals('a1', $space->name());
    }
}
