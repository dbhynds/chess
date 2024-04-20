<?php

namespace Tests\Unit\Pieces;

use App\Models\Board\File;
use App\Models\Board\Rank;
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
        $this->space = new Space(File::b, Rank::i2);
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
        $b2 = new Space(File::b, Rank::i2);
        $c2 = new Space(File::c, Rank::i2);
        $piece = new Pawn(Color::White, $this->space);

        $piece->setSpace($c2);

        $this->assertEquals($c2, $piece->space());
    }

    public function testNameReturnsPawn(): void
    {
        $piece = new Pawn(Color::White, $this->space);

        $this->assertEquals(Pieces::Pawn, $piece->name());
    }

    public function testPossibleMovesReturnsPossibleMoves(): void
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
        $space = new Space(File::d, Rank::i4);
        $piece = new Pawn(Color::White, $space);

        $this->assertCount(8, $piece->filteredMoves());
    }

    public function testMoveIsValidForThisColorReturnsTrueForWhiteUp(): void
    {
        $space = new Space(File::d, Rank::i4);
        $piece = new Pawn(Color::White, $space);
        $move = Move::make($piece)->withVector(0, 1);

        $this->assertTrue($piece->moveIsValidForThisColor($move));
    }

    public function testMoveIsValidForThisColorReturnsFalseForWhiteDown(): void
    {
        $space = new Space(File::d, Rank::i4);
        $piece = new Pawn(Color::White, $space);
        $move = Move::make($piece)->withVector(0, -1);

        $this->assertFalse($piece->moveIsValidForThisColor($move));
    }

    public function testMoveIsValidForThisColorReturnsTrueForBlackDown(): void
    {
        $space = new Space(File::d, Rank::i4);
        $piece = new Pawn(Color::Black, $space);
        $move = Move::make($piece)->withVector(0, -1);

        $this->assertTrue($piece->moveIsValidForThisColor($move));
    }

    public function testMoveIsValidForThisColorReturnsFalseForBlackUp(): void
    {
        $space = new Space(File::d, Rank::i4);
        $piece = new Pawn(Color::Black, $space);
        $move = Move::make($piece)->withVector(0, 1);

        $this->assertFalse($piece->moveIsValidForThisColor($move));
    }

    public function testMovesReturnsValidMovesForWhite(): void
    {
        $space = new Space(File::d, Rank::i4);
        $piece = new Pawn(Color::White, $space);
        $validMoves = ['c5', 'd5', 'd6', 'e5'];

        $moves = $piece->moves();

        $this->assertCount(4, $moves);
        foreach ($moves as $move) {
            $this->assertContains($move->newSpace()->name(), $validMoves);
        }
    }

    public function testMovesReturnsNoValidMovesForWhiteAtEndOfTheBoard(): void
    {
        $space = new Space(File::d, Rank::i8);
        $piece = new Pawn(Color::White, $space);

        $moves = $piece->moves();

        $this->assertCount(0, $moves);
    }

    public function testMovesReturnsValidMovesForBlack(): void
    {
        $space = new Space(File::d, Rank::i4);
        $piece = new Pawn(Color::Black, $space);
        $validMoves = ['c3', 'd3', 'd2', 'e3'];

        $moves = $piece->moves();

        $this->assertCount(count($validMoves), $moves);
        foreach ($moves as $move) {
            $this->assertContains($move->newSpace()->name(), $validMoves);
        }
    }

    public function testCanCapture(): void
    {
        $space = new Space(File::d, Rank::i4);
        $black = new Pawn(Color::Black, $space);
        $white = new Pawn(Color::White, $space);

        $this->assertTrue($black->canCapture($white));
        $this->assertTrue($white->canCapture($black));
        $this->assertFalse($white->canCapture($white));
        $this->assertFalse($black->canCapture($black));
    }
}
