<?php

namespace Tests\Unit\Pieces;

use App\Models\Board\Column;
use App\Models\Board\Row;
use App\Models\Board\Space;
use App\Models\Game\Move\Move;
use App\Models\Pieces\Pawn;
use App\Models\Pieces\Pieces;
use App\Models\Players\Color;
use PHPUnit\Framework\TestCase;

class PawnTest extends TestCase
{
    private Space $space;

    protected function setUp(): void
    {
        $this->space = new Space(Column::B, Row::i2);
    }

    public function testInstantiates(): void
    {
        $piece = new Pawn(Color::White, $this->space);
        $this->assertInstanceOf(Pawn::class, $piece);
    }

    public function testColorReturnsColor(): void
    {
        $piece = new Pawn(Color::White, $this->space);

        $this->assertEquals(Color::White, $piece->color());
    }

    public function testSpaceReturnsSpace(): void
    {
        $piece = new Pawn(Color::White, $this->space);

        $this->assertEquals($this->space, $piece->space());
    }

    public function testIsCapturedReturnsFalse(): void
    {
        $piece = new Pawn(Color::White, $this->space);

        $this->assertFalse($piece->isCaptured());
    }

    public function testCaptureCapturesPiece(): void
    {
        $piece = new Pawn(Color::White, $this->space);

        $piece->capture();

        $this->assertTrue($piece->isCaptured());
    }

    public function testSetSpaceSetsANewSpace(): void
    {
        $B2 = new Space(Column::B, Row::i2);
        $C2 = new Space(Column::C, Row::i2);
        $piece = new Pawn(Color::White, $this->space);

        $piece->setSpace($C2);

        $this->assertEquals($C2, $piece->space());
    }

    public function testNameReturnsPawn(): void
    {
        $piece = new Pawn(Color::White, $this->space);

        $this->assertEquals(Pieces::Pawn, $piece->name());
    }

    public function testPossibleMovesReturnsPossibleMovesForWhite(): void
    {
        $piece = new Pawn(Color::White, $this->space);

        $this->assertCount(8, $piece->possibleMoves());
    }

    public function testRequiresAClearPathReturnsTrue(): void
    {
        $piece = new Pawn(Color::White, $this->space);

        $this->assertTrue($piece->requiresAClearPath());
    }

    public function testFilteredMovesReturnsValidMoves(): void
    {
        $space = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $space);

        $this->assertCount(8, $piece->filteredMoves());
    }

    public function testMoveIsValidForThisColorReturnsTrueForWhiteUp(): void
    {
        $space = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $space);
        $move = Move::make($piece)->withVector(0, 1);

        $this->assertTrue($piece->moveIsValidForThisColor($move));
    }

    public function testMoveIsValidForThisColorReturnsFalseForWhiteDown(): void
    {
        $space = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $space);
        $move = Move::make($piece)->withVector(0, -1);

        $this->assertFalse($piece->moveIsValidForThisColor($move));
    }

    public function testMoveIsValidForThisColorReturnsTrueForBlackDown(): void
    {
        $space = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::Black, $space);
        $move = Move::make($piece)->withVector(0, -1);

        $this->assertTrue($piece->moveIsValidForThisColor($move));
    }

    public function testMoveIsValidForThisColorReturnsFalseForBlackUp(): void
    {
        $space = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::Black, $space);
        $move = Move::make($piece)->withVector(0, 1);

        $this->assertFalse($piece->moveIsValidForThisColor($move));
    }

    public function testMovesReturnsValidMovesForWhite(): void
    {
        $space = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $space);
        $validMoves = ['C5', 'D5', 'D6', 'E5'];

        $moves = $piece->moves();

        $this->assertCount(4, $moves);
        foreach ($moves as $move) {
            $this->assertContains($move->newSpace()->name(), $validMoves);
        }
    }

    public function testMovesReturnsNoValidMovesForWhiteAtEndOfTheBoard(): void
    {
        $space = new Space(Column::D, Row::i8);
        $piece = new Pawn(Color::White, $space);

        $moves = $piece->moves();

        $this->assertCount(0, $moves);
    }

    public function testMovesReturnsValidMovesForBlack(): void
    {
        $space = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::Black, $space);
        $validMoves = ['C3', 'D3', 'D2', 'E3'];

        $moves = $piece->moves();

        $this->assertCount(count($validMoves), $moves);
        foreach ($moves as $move) {
            $this->assertContains($move->newSpace()->name(), $validMoves);
        }
    }

    public function testCanCapture(): void
    {
        $space = new Space(Column::D, Row::i4);
        $black = new Pawn(Color::Black, $space);
        $white = new Pawn(Color::White, $space);

        $this->assertTrue($black->canCapture($white));
        $this->assertTrue($white->canCapture($black));
        $this->assertFalse($white->canCapture($white));
        $this->assertFalse($black->canCapture($black));
    }
}
