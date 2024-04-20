<?php

namespace Tests\Unit\Pieces;

use App\Models\Board\File;
use App\Models\Board\Rank;
use App\Models\Board\Space;
use App\Models\Pieces\Pieces;
use App\Models\Pieces\Queen;
use App\Models\Players\Color;
use PHPUnit\Framework\TestCase;

class QueenTest extends TestCase
{
    private Space $space;

    protected function setUp(): void
    {
        $this->space = new Space(File::d, Rank::i4);
    }

    public function testInstantiates(): void
    {
        $piece = new Queen(Color::White, $this->space);
        $this->assertInstanceOf(Queen::class, $piece);
    }

    public function testNameReturnsQueen(): void
    {
        $piece = new Queen(Color::White, $this->space);

        $this->assertEquals(Pieces::Queen, $piece->name());
    }

    public function testPossibleMovesReturnsPossibleMoves(): void
    {
        $piece = new Queen(Color::White, $this->space);

        $this->assertCount(56, $piece->possibleMoves());
    }

    public function testRequiresAClearPathReturnsTrue(): void
    {
        $piece = new Queen(Color::White, $this->space);

        $this->assertTrue($piece->requiresAClearPath());
    }

    public function testFilteredMovesReturnsValidMoves(): void
    {
        $piece = new Queen(Color::White, $this->space);

        $this->assertCount(27, $piece->filteredMoves());
    }

    public function testMovesReturnsValidMoves(): void
    {
        $piece = new Queen(Color::Black, $this->space);
        $validMoves = [
            'a1', 'b2', 'c3', 'e5', 'f6', 'g7', 'h8',
            'a7', 'b6', 'c5', 'e3', 'f2', 'g1',
            'd1', 'd2', 'd3', 'd5', 'd6', 'd7', 'd8',
            'a4', 'b4', 'c4', 'e4', 'f4', 'g4', 'h4',
        ];

        $moves = $piece->moves();

        $this->assertCount(count($validMoves), $moves);
        foreach ($moves as $move) {
            $this->assertContains($move->newSpace()->name(), $validMoves);
        }
    }
}
