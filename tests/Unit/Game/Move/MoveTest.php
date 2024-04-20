<?php

namespace Tests\Unit\Game\Move;

use App\Models\Board\File;
use App\Models\Board\Rank;
use App\Models\Board\Space;
use App\Models\Game\Game;
use App\Models\Game\Move\Direction;
use App\Models\Game\Move\Move;
use App\Models\Pieces\Pawn;
use App\Models\Players\Color;
use PHPUnit\Framework\TestCase;

class MoveTest extends TestCase
{
    public function testInstantiates(): void
    {
        $H1 = new Space(File::H, Rank::i1);
        $piece = new Pawn(Color::White, $H1);
        $move = new Move($piece);

        $this->assertInstanceOf(Move::class, $move);
    }

    public function testMakeInstantiates(): void
    {
        $H1 = new Space(File::H, Rank::i1);
        $piece = new Pawn(Color::White, $H1);
        $move = Move::make($piece);

        $this->assertInstanceOf(Move::class, $move);
    }

    public function testPieceReturnsPiece(): void
    {
        $H1 = new Space(File::H, Rank::i1);
        $piece = new Pawn(Color::White, $H1);
        $move = new Move($piece);

        $actual = $move->piece();

        $this->assertEquals($piece, $actual);
    }

    public function testOriginalSpaceReturnsOriginalSpace(): void
    {
        $H1 = new Space(File::H, Rank::i1);
        $piece = new Pawn(Color::White, $H1);
        $move = new Move($piece);

        $actual = $move->originalSpace();

        $this->assertEquals($H1, $actual);
    }

    public function testNewSpaceReturnsOriginalSpaceIfNotMoved(): void
    {
        $H1 = new Space(File::H, Rank::i1);
        $piece = new Pawn(Color::White, $H1);
        $move = new Move($piece);

        $actual = $move->newSpace();

        $this->assertEquals($H1, $actual);
    }

    public function testToSetsNewSpace(): void
    {
        $H1 = new Space(File::H, Rank::i1);
        $A8 = new Space(File::A, Rank::i8);
        $piece = new Pawn(Color::White, $H1);
        $move = Move::make($piece)->to($A8);

        $this->assertEquals($A8, $move->newSpace());
    }

    public function testVectorReturnsTheSpaceAboveD4(): void
    {
        $D4 = new Space(File::D, Rank::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->withVector(0, 1);

        $this->assertEquals('D5', $move->newSpace()->name());
        $this->assertTrue($move->isOnTheBoard());
    }

    public function testVectorReturnsTheSpaceTwoAboveD4(): void
    {
        $D4 = new Space(File::D, Rank::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->withVector(0, 2);

        $this->assertEquals('D6', $move->newSpace()->name());
        $this->assertTrue($move->isOnTheBoard());
    }

    public function testVectorReturnsTheSpaceLeftOfD4(): void
    {
        $D4 = new Space(File::D, Rank::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->withVector(-1, 0);

        $this->assertEquals('C4', $move->newSpace()->name());
        $this->assertTrue($move->isOnTheBoard());
    }

    public function testVectorReturnsTheSpaceDiagonallyRightAndDownFromD4(): void
    {
        $D4 = new Space(File::D, Rank::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->withVector(1, -1);

        $this->assertEquals('E3', $move->newSpace()->name());
        $this->assertTrue($move->isOnTheBoard());
    }

    public function testVectorReturnsNullIfOffTheBoard(): void
    {
        $D4 = new Space(File::D, Rank::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->withVector(5, 5);

        $this->assertNull($move->newSpace());
        $this->assertFalse($move->isOnTheBoard());
    }

    public function testIsDirectionUp(): void
    {
        $D4 = new Space(File::D, Rank::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->withVector(0, 1);
        $this->assertTrue($move->isDirection(Direction::Up));

        $move = Move::make($piece)->withVector(0, 2);
        $this->assertTrue($move->isDirection(Direction::Up));

        $move = Move::make($piece)->withVector(0, 10);
        $this->assertFalse($move->isDirection(Direction::Up));

        $move = Move::make($piece)->withVector(0, -1);
        $this->assertFalse($move->isDirection(Direction::Up));

        $move = new Move($piece);
        $this->assertFalse($move->isDirection(Direction::Up));
    }

    public function testIsDirectionDown(): void
    {
        $D4 = new Space(File::D, Rank::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->withVector(0, -1);
        $this->assertTrue($move->isDirection(Direction::Down));

        $move = Move::make($piece)->withVector(0, -2);
        $this->assertTrue($move->isDirection(Direction::Down));

        $move = Move::make($piece)->withVector(0, -10);
        $this->assertFalse($move->isDirection(Direction::Down));

        $move = Move::make($piece)->withVector(0, 1);
        $this->assertFalse($move->isDirection(Direction::Down));

        $move = new Move($piece);
        $this->assertFalse($move->isDirection(Direction::Down));
    }

    public function testIsDirectionLeft(): void
    {
        $D4 = new Space(File::D, Rank::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->withVector(-1, 0);
        $this->assertTrue($move->isDirection(Direction::Left));

        $move = Move::make($piece)->withVector(-2, 0);
        $this->assertTrue($move->isDirection(Direction::Left));

        $move = Move::make($piece)->withVector(-10, 0);
        $this->assertFalse($move->isDirection(Direction::Left));

        $move = Move::make($piece)->withVector(1, 0);
        $this->assertFalse($move->isDirection(Direction::Left));

        $move = new Move($piece);
        $this->assertFalse($move->isDirection(Direction::Left));
    }

    public function testIsDirectionRight(): void
    {
        $D4 = new Space(File::D, Rank::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->withVector(1, 0);
        $this->assertTrue($move->isDirection(Direction::Right));

        $move = Move::make($piece)->withVector(2, 0);
        $this->assertTrue($move->isDirection(Direction::Right));

        $move = Move::make($piece)->withVector(10, 0);
        $this->assertFalse($move->isDirection(Direction::Right));

        $move = Move::make($piece)->withVector(-1, 0);
        $this->assertFalse($move->isDirection(Direction::Right));

        $move = new Move($piece);
        $this->assertFalse($move->isDirection(Direction::Right));
    }

    public function testCapturesAPiece(): void
    {
        $black = app(Game::class)->activePieces()->filter(fn ($piece) => $piece->isBlack())->first();
        $white = app(Game::class)->activePieces()->filter(fn ($piece) => $piece->isWhite())->first();

        $move = Move::make($black)->to($white->space());
        $this->assertTrue($move->capturesAPiece());

        $move = Move::make($black)->to($black->space());
        $this->assertFalse($move->capturesAPiece());

        $move = Move::make($black);
        $this->assertFalse($move->capturesAPiece());
    }

    public function testCapturedPiece(): void
    {
        $black = app(Game::class)->activePieces()->filter(fn ($piece) => $piece->isBlack())->first();
        $white = app(Game::class)->activePieces()->filter(fn ($piece) => $piece->isWhite())->first();

        $move = Move::make($black)->to($white->space());
        $this->assertEquals($white, $move->capturedPiece());
    }

    public function testVector(): void
    {
        $D4 = new Space(File::D, Rank::i4);
        $D6 = new Space(File::D, Rank::i6);
        $C5 = new Space(File::C, Rank::i5);
        $E3 = new Space(File::E, Rank::i3);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->to($D6);
        $this->assertEquals([0, 2], $move->vector());

        $move = Move::make($piece)->to($C5);
        $this->assertEquals([-1, 1], $move->vector());

        $move = Move::make($piece)->to($E3);
        $this->assertEquals([1, -1], $move->vector());
    }

    public function testPath(): void
    {
        // Piece on D4
        $D4 = new Space(File::D, Rank::i4);
        $piece = new Pawn(Color::White, $D4);

        // Bottom left to top right
        $A1 = new Space(File::A, Rank::i1);
        $B2 = new Space(File::B, Rank::i2);
        $C3 = new Space(File::C, Rank::i3);
        $E5 = new Space(File::E, Rank::i5);
        $F6 = new Space(File::F, Rank::i6);
        $G7 = new Space(File::G, Rank::i7);
        $H8 = new Space(File::H, Rank::i8);

        // Diagonal, up right
        $move = Move::make($piece)->to($H8);
        $this->assertEquals([$E5, $F6, $G7], $move->path());

        // Diagonal, down left
        $move = Move::make($piece)->to($A1);
        $this->assertEquals([$C3, $B2], $move->path());

        // Top left to bottom right
        $A7 = new Space(File::A, Rank::i7);
        $B6 = new Space(File::B, Rank::i6);
        $C5 = new Space(File::C, Rank::i5);
        $E3 = new Space(File::E, Rank::i3);
        $F2 = new Space(File::F, Rank::i2);
        $G1 = new Space(File::G, Rank::i1);

        // Diagonal, up left
        $move = Move::make($piece)->to($A7);
        $this->assertEquals([$C5, $B6], $move->path());

        // Diagonal, down right
        $move = Move::make($piece)->to($G1);
        $this->assertEquals([$E3, $F2], $move->path());

        // File 4
        $A4 = new Space(File::A, Rank::i4);
        $B4 = new Space(File::B, Rank::i4);
        $C4 = new Space(File::C, Rank::i4);
        $E4 = new Space(File::E, Rank::i4);
        $F4 = new Space(File::F, Rank::i4);
        $G4 = new Space(File::G, Rank::i4);
        $H4 = new Space(File::H, Rank::i4);

        // Up
        $move = Move::make($piece)->to($H4);
        $this->assertEquals([$E4, $F4, $G4], $move->path());

        // Down
        $move = Move::make($piece)->to($A4);
        $this->assertEquals([$C4, $B4], $move->path());

        // Rank D
        $D1 = new Space(File::D, Rank::i1);
        $D2 = new Space(File::D, Rank::i2);
        $D3 = new Space(File::D, Rank::i3);
        $D5 = new Space(File::D, Rank::i5);
        $D6 = new Space(File::D, Rank::i6);
        $D7 = new Space(File::D, Rank::i7);
        $D8 = new Space(File::D, Rank::i8);

        // Left
        $move = Move::make($piece)->to($D1);
        $this->assertEquals([$D3, $D2], $move->path());

        // Right
        $move = Move::make($piece)->to($D8);
        $this->assertEquals([$D5, $D6, $D7], $move->path());
    }

    public function testIsObstructed(): void
    {
        $B2 = new Space(File::B, Rank::i2);
        $B3 = new Space(File::B, Rank::i3);
        $B4 = new Space(File::B, Rank::i4);
        $piece = new Pawn(Color::White, $B2);
        $game = app(Game::class);
        // Ensure the same instance always gets resolved
        app()->instance(Game::class, $game);

        // Place a piece with no blockers
        $game->place($piece);
        $move = Move::make($piece)->to($B4);
        $this->assertFalse($move->isObstructed());

        // Now add a blocker
        $blocker = new Pawn(Color::White, $B3);
        $game->place($blocker);
        $move = Move::make($piece)->to($B4);
        $this->assertTrue($move->isObstructed());

        // @todo test pieces that don't require a clear path
    }
}
