<?php

namespace Tests\Unit\Pieces;

use App\Models\Board\Column;
use App\Models\Board\Row;
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
        $this->space = new Space(Column::D, Row::i4);
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

    public function testPossibleMovesReturnsPossibleMovesForWhite(): void
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
            'A1', 'B2', 'C3', 'E5', 'F6', 'G7', 'H8',
            'A7', 'B6', 'C5', 'E3', 'F2', 'G1',
            'D1', 'D2', 'D3', 'D5', 'D6', 'D7', 'D8',
            'A4', 'B4', 'C4', 'E4', 'F4', 'G4', 'H4',
        ];

        $moves = $piece->moves();

        $this->assertCount(count($validMoves), $moves);
        foreach ($moves as $move) {
            $this->assertContains($move->newSpace()->name(), $validMoves);
        }
    }
}
