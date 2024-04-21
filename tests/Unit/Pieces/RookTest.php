<?php

namespace Tests\Unit\Pieces;

use App\Models\Board\File;
use App\Models\Board\Rank;
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
        $this->space = new Space(File::d, Rank::i4);
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

    public function testNotation(): void
    {
        $piece = new Rook(Color::White, $this->space);

        $this->assertEquals(Pieces::Rook->value, $piece->notation());
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
