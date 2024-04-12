<?php

namespace Tests\Unit\Game\Move;

use App\Models\Board\Column;
use App\Models\Board\Row;
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
        $H1 = new Space(Column::H, Row::i1);
        $piece = new Pawn(Color::White, $H1);
        $move = new Move($piece);

        $this->assertInstanceOf(Move::class, $move);
    }

    public function testMakeInstantiates(): void
    {
        $H1 = new Space(Column::H, Row::i1);
        $piece = new Pawn(Color::White, $H1);
        $move = Move::make($piece);

        $this->assertInstanceOf(Move::class, $move);
    }

    public function testPieceReturnsPiece(): void
    {
        $H1 = new Space(Column::H, Row::i1);
        $piece = new Pawn(Color::White, $H1);
        $move = new Move($piece);

        $actual = $move->piece();

        $this->assertEquals($piece, $actual);
    }

    public function testOriginalSpaceReturnsOriginalSpace(): void
    {
        $H1 = new Space(Column::H, Row::i1);
        $piece = new Pawn(Color::White, $H1);
        $move = new Move($piece);

        $actual = $move->originalSpace();

        $this->assertEquals($H1, $actual);
    }

    public function testNewSpaceReturnsOriginalSpaceIfNotMoved(): void
    {
        $H1 = new Space(Column::H, Row::i1);
        $piece = new Pawn(Color::White, $H1);
        $move = new Move($piece);

        $actual = $move->newSpace();

        $this->assertEquals($H1, $actual);
    }

    public function testToSetsNewSpace(): void
    {
        $H1 = new Space(Column::H, Row::i1);
        $A8 = new Space(Column::A, Row::i8);
        $piece = new Pawn(Color::White, $H1);
        $move = Move::make($piece)->to($A8);

        $this->assertEquals($A8, $move->newSpace());
    }

    public function testVectorReturnsTheSpaceAboveD4(): void
    {
        $D4 = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->withVector(0, 1);

        $this->assertEquals('D5', $move->newSpace()->name());
        $this->assertTrue($move->isOnTheBoard());
    }

    public function testVectorReturnsTheSpaceTwoAboveD4(): void
    {
        $D4 = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->withVector(0, 2);

        $this->assertEquals('D6', $move->newSpace()->name());
        $this->assertTrue($move->isOnTheBoard());
    }

    public function testVectorReturnsTheSpaceLeftOfD4(): void
    {
        $D4 = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->withVector(-1, 0);

        $this->assertEquals('C4', $move->newSpace()->name());
        $this->assertTrue($move->isOnTheBoard());
    }

    public function testVectorReturnsTheSpaceDiagonallyRightAndDownFromD4(): void
    {
        $D4 = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->withVector(1, -1);

        $this->assertEquals('E3', $move->newSpace()->name());
        $this->assertTrue($move->isOnTheBoard());
    }

    public function testVectorReturnsNullIfOffTheBoard(): void
    {
        $D4 = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->withVector(5, 5);

        $this->assertNull($move->newSpace());
        $this->assertFalse($move->isOnTheBoard());
    }

    public function testIsDirectionUp(): void
    {
        $D4 = new Space(Column::D, Row::i4);
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
        $D4 = new Space(Column::D, Row::i4);
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
        $D4 = new Space(Column::D, Row::i4);
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
        $D4 = new Space(Column::D, Row::i4);
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
        $D4 = new Space(Column::D, Row::i4);
        $D6 = new Space(Column::D, Row::i6);
        $C5 = new Space(Column::C, Row::i5);
        $E3 = new Space(Column::E, Row::i3);
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
        $D4 = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $D4);

        // Bottom left to top right
        $A1 = new Space(Column::A, Row::i1);
        $B2 = new Space(Column::B, Row::i2);
        $C3 = new Space(Column::C, Row::i3);
        $E5 = new Space(Column::E, Row::i5);
        $F6 = new Space(Column::F, Row::i6);
        $G7 = new Space(Column::G, Row::i7);
        $H8 = new Space(Column::H, Row::i8);

        // Diagonal, up right
        $move = Move::make($piece)->to($H8);
        $this->assertEquals([$E5, $F6, $G7], $move->path());

        // Diagonal, down left
        $move = Move::make($piece)->to($A1);
        $this->assertEquals([$C3, $B2], $move->path());

        // Top left to bottom right
        $A7 = new Space(Column::A, Row::i7);
        $B6 = new Space(Column::B, Row::i6);
        $C5 = new Space(Column::C, Row::i5);
        $E3 = new Space(Column::E, Row::i3);
        $F2 = new Space(Column::F, Row::i2);
        $G1 = new Space(Column::G, Row::i1);

        // Diagonal, up left
        $move = Move::make($piece)->to($A7);
        $this->assertEquals([$C5, $B6], $move->path());

        // Diagonal, down right
        $move = Move::make($piece)->to($G1);
        $this->assertEquals([$E3, $F2], $move->path());

        // Column 4
        $A4 = new Space(Column::A, Row::i4);
        $B4 = new Space(Column::B, Row::i4);
        $C4 = new Space(Column::C, Row::i4);
        $E4 = new Space(Column::E, Row::i4);
        $F4 = new Space(Column::F, Row::i4);
        $G4 = new Space(Column::G, Row::i4);
        $H4 = new Space(Column::H, Row::i4);

        // Up
        $move = Move::make($piece)->to($H4);
        $this->assertEquals([$E4, $F4, $G4], $move->path());

        // Down
        $move = Move::make($piece)->to($A4);
        $this->assertEquals([$C4, $B4], $move->path());

        // Row D
        $D1 = new Space(Column::D, Row::i1);
        $D2 = new Space(Column::D, Row::i2);
        $D3 = new Space(Column::D, Row::i3);
        $D5 = new Space(Column::D, Row::i5);
        $D6 = new Space(Column::D, Row::i6);
        $D7 = new Space(Column::D, Row::i7);
        $D8 = new Space(Column::D, Row::i8);

        // Left
        $move = Move::make($piece)->to($D1);
        $this->assertEquals([$D3, $D2], $move->path());

        // Right
        $move = Move::make($piece)->to($D8);
        $this->assertEquals([$D5, $D6, $D7], $move->path());
    }

    public function testIsObstructed(): void
    {
        $B2 = new Space(Column::B, Row::i2);
        $B3 = new Space(Column::B, Row::i3);
        $B4 = new Space(Column::B, Row::i4);
        $piece = new Pawn(Color::White, $B2);
        $blocker = new Pawn(Color::White, $B3);
        $game = app(Game::class);

        $game->place($piece);
        $game->place($blocker);

        $move = Move::make($piece)->to($B4);
        $this->assertTrue($move->isObstructed());

        // @todo test pieces that don't require a clear path
    }
}
