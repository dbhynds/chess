<?php

namespace Tests\Unit\Pieces;

use App\Models\Board\Column;
use App\Models\Board\Row;
use App\Models\Board\Space;
use App\Models\Pieces\Pieces;
use App\Models\Pieces\Rook;
use App\Models\Players\Color;
use PHPUnit\Framework\TestCase;

class RookTest extends TestCase
{
    private Space $space;

    protected function setUp(): void
    {
        $this->space = new Space(Column::D, Row::i4);
    }

    public function testInstantiates(): void
    {
        $piece = new Rook(Color::White, $this->space);
        $this->assertInstanceOf(Rook::class, $piece);
    }

    public function testNameReturnsRook(): void
    {
        $piece = new Rook(Color::White, $this->space);

        $this->assertEquals(Pieces::Rook, $piece->name());
    }

    public function testPossibleMovesReturnsPossibleMoves(): void
    {
        $piece = new Rook(Color::White, $this->space);

        $this->assertCount(28, $piece->possibleMoves());
    }

    public function testRequiresAClearPathReturnsTrue(): void
    {
        $piece = new Rook(Color::White, $this->space);

        $this->assertTrue($piece->requiresAClearPath());
    }

    public function testFilteredMovesReturnsValidMoves(): void
    {
        $piece = new Rook(Color::White, $this->space);

        $this->assertCount(14, $piece->filteredMoves());
    }

    public function testMovesReturnsValidMoves(): void
    {
        $piece = new Rook(Color::Black, $this->space);
        $validMoves = [
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
