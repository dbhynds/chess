<?php

namespace Tests\Unit\Pieces;

use App\Models\Board\Column;
use App\Models\Board\Row;
use App\Models\Board\Space;
use App\Models\Pieces\King;
use App\Models\Pieces\Pieces;
use App\Models\Players\Color;
use PHPUnit\Framework\TestCase;

class KingTest extends TestCase
{
    private Space $space;

    protected function setUp(): void
    {
        $this->space = new Space(Column::D, Row::i4);
    }

    public function testInstantiates(): void
    {
        $piece = new King(Color::White, $this->space);
        $this->assertInstanceOf(King::class, $piece);
    }

    public function testNameReturnsKing(): void
    {
        $piece = new King(Color::White, $this->space);

        $this->assertEquals(Pieces::King, $piece->name());
    }

    public function testPossibleMovesReturnsPossibleMoves(): void
    {
        $piece = new King(Color::White, $this->space);

        $this->assertCount(12, $piece->possibleMoves());
    }

    public function testRequiresAClearPathReturnsTrue(): void
    {
        $piece = new King(Color::White, $this->space);

        $this->assertTrue($piece->requiresAClearPath());
    }

    public function testFilteredMovesReturnsValidMoves(): void
    {
        $piece = new King(Color::White, $this->space);

        $this->assertCount(12, $piece->filteredMoves());
    }

    public function testMovesReturnsValidMoves(): void
    {
        $piece = new King(Color::Black, $this->space);
        $validMoves = [
            'C3', 'C4', 'C5',
            'D3', 'D5',
            'E3', 'E4', 'E5',
        ];

        $moves = $piece->moves();

        $this->assertCount(count($validMoves), $moves);
        foreach ($moves as $move) {
            $this->assertContains($move->newSpace()->name(), $validMoves);
        }
    }
}
