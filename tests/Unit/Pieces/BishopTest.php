<?php

namespace Tests\Unit\Pieces;

use App\Models\Board\File;
use App\Models\Board\Rank;
use App\Models\Board\Space;
use App\Models\Pieces\Bishop;
use App\Models\Pieces\Pieces;
use App\Models\Players\Color;
use PHPUnit\Framework\TestCase;

class BishopTest extends TestCase
{
    private Space $space;

    protected function setUp(): void
    {
        $this->space = new Space(File::d, Rank::i4);
    }

    public function testInstantiates(): void
    {
        $piece = new Bishop(Color::White, $this->space);
        $this->assertInstanceOf(Bishop::class, $piece);
    }

    public function testNameReturnsBishop(): void
    {
        $piece = new Bishop(Color::White, $this->space);

        $this->assertEquals(Pieces::Bishop, $piece->name());
    }

    public function testNotation(): void
    {
        $piece = new Bishop(Color::White, $this->space);

        $this->assertEquals(Pieces::Bishop->value, $piece->notation());
    }

    public function testPossibleMovesReturnsPossibleMoves(): void
    {
        $piece = new Bishop(Color::White, $this->space);

        $this->assertCount(28, $piece->possibleMoves());
    }

    public function testRequiresAClearPathReturnsTrue(): void
    {
        $piece = new Bishop(Color::White, $this->space);

        $this->assertTrue($piece->requiresAClearPath());
    }

    public function testFilteredMovesReturnsValidMoves(): void
    {
        $piece = new Bishop(Color::White, $this->space);

        $this->assertCount(13, $piece->filteredMoves());
    }

    public function testMovesReturnsValidMoves(): void
    {
        $piece = new Bishop(Color::Black, $this->space);
        $validMoves = [
            'a1', 'b2', 'c3', 'e5', 'f6', 'g7', 'h8',
            'a7', 'b6', 'c5', 'e3', 'f2', 'g1',
        ];

        $moves = $piece->moves();

        $this->assertCount(count($validMoves), $moves);
        foreach ($moves as $move) {
            $this->assertContains($move->newSpace()->name(), $validMoves);
        }
    }
}
