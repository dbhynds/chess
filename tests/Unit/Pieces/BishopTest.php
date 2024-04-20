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
        $this->space = new Space(File::D, Rank::i4);
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
            'A1', 'B2', 'C3', 'E5', 'F6', 'G7', 'H8',
            'A7', 'B6', 'C5', 'E3', 'F2', 'G1',
        ];

        $moves = $piece->moves();

        $this->assertCount(count($validMoves), $moves);
        foreach ($moves as $move) {
            $this->assertContains($move->newSpace()->name(), $validMoves);
        }
    }
}
