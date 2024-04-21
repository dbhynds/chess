<?php

namespace Tests\Unit\Pieces;

use App\Models\Board\File;
use App\Models\Board\Rank;
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
        $this->space = new Space(File::d, Rank::i4);
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

    public function testNotation(): void
    {
        $piece = new King(Color::White, $this->space);

        $this->assertEquals(Pieces::King->value, $piece->notation());
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
            'c3', 'c4', 'c5',
            'd3', 'd5',
            'e3', 'e4', 'e5',
        ];

        $moves = $piece->moves();

        // @todo Fix this test
        // $this->assertCount(count($validMoves), $moves);
        // foreach ($moves as $move) {
        //     $this->assertContains($move->newSpace()->name(), $validMoves);
        // }
    }
}
