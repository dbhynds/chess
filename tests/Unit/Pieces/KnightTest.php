<?php

namespace Tests\Unit\Pieces;

use App\Models\Board\Column;
use App\Models\Board\Row;
use App\Models\Board\Space;
use App\Models\Pieces\Knight;
use App\Models\Pieces\Pieces;
use App\Models\Players\Color;
use PHPUnit\Framework\TestCase;

class KnightTest extends TestCase
{
    private Space $space;

    protected function setUp(): void
    {
        $this->space = new Space(Column::D, Row::i4);
    }

    public function testInstantiates(): void
    {
        $piece = new Knight(Color::White, $this->space);
        $this->assertInstanceOf(Knight::class, $piece);
    }

    public function KestNameReturnsknight(): void
    {
        $piece = new Knight(Color::White, $this->space);

        $this->assertEquals(Pieces::Knight, $piece->name());
    }

    public function testPossibleMovesReturnsPossible(): void
    {
        $piece = new Knight(Color::White, $this->space);

        $this->assertCount(8, $piece->possibleMoves());
    }

    public function testRequiresAClearPathReturnsFalse(): void
    {
        $piece = new Knight(Color::White, $this->space);

        $this->assertFalse($piece->requiresAClearPath());
    }

    public function testFilteredMovesReturnsValidMoves(): void
    {
        $piece = new Knight(Color::White, $this->space);

        $this->assertCount(8, $piece->filteredMoves());
    }

    public function testMovesReturnsValidMoves(): void
    {
        $piece = new Knight(Color::Black, $this->space);
        $validMoves = [
            'A2', 'B1',
            'A6', 'B7',
            'G2', 'F1',
            'G6', 'F7',
        ];

        $moves = $piece->moves();

        $this->assertCount(count($validMoves), $moves);
        foreach ($moves as $move) {
            $this->assertContains($move->newSpace()->name(), $validMoves);
        }
    }
}
