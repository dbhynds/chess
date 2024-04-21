<?php

namespace Tests\Unit\Pieces;

use App\Models\Board\File;
use App\Models\Board\Rank;
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
        $this->space = new Space(File::d, Rank::i4);
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

    public function testNotation(): void
    {
        $piece = new Knight(Color::White, $this->space);

        $this->assertEquals(Pieces::Knight->value, $piece->notation());
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
            'a2', 'b1',
            'a6', 'b7',
            'g2', 'f1',
            'g6', 'f7',
        ];

        $moves = $piece->moves();

        $this->assertCount(count($validMoves), $moves);
        foreach ($moves as $move) {
            $this->assertContains($move->newSpace()->name(), $validMoves);
        }
    }
}
