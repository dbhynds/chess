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

        $move = Move::make($piece)->vector(0, 1);

        $this->assertEquals('D5', $move->newSpace()->name());
        $this->assertTrue($move->isOnTheBoard());
    }

    public function testVectorReturnsTheSpaceTwoAboveD4(): void
    {
        $D4 = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->vector(0, 2);

        $this->assertEquals('D6', $move->newSpace()->name());
        $this->assertTrue($move->isOnTheBoard());
    }

    public function testVectorReturnsTheSpaceLeftOfD4(): void
    {
        $D4 = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->vector(-1, 0);

        $this->assertEquals('C4', $move->newSpace()->name());
        $this->assertTrue($move->isOnTheBoard());
    }

    public function testVectorReturnsTheSpaceDiagonallyRightAndDownFromD4(): void
    {
        $D4 = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->vector(1, -1);

        $this->assertEquals('E3', $move->newSpace()->name());
        $this->assertTrue($move->isOnTheBoard());
    }

    public function testVectorReturnsNullIfOffTheBoard(): void
    {
        $D4 = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->vector(5, 5);

        $this->assertNull($move->newSpace());
        $this->assertFalse($move->isOnTheBoard());
    }

    public function testIsDirectionUp(): void
    {
        $D4 = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->vector(0, 1);
        $this->assertTrue($move->isDirection(Direction::Up));

        $move = Move::make($piece)->vector(0, 2);
        $this->assertTrue($move->isDirection(Direction::Up));

        $move = Move::make($piece)->vector(0, 10);
        $this->assertFalse($move->isDirection(Direction::Up));

        $move = Move::make($piece)->vector(0, -1);
        $this->assertFalse($move->isDirection(Direction::Up));

        $move = new Move($piece);
        $this->assertFalse($move->isDirection(Direction::Up));
    }

    public function testIsDirectionDown(): void
    {
        $D4 = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->vector(0, -1);
        $this->assertTrue($move->isDirection(Direction::Down));

        $move = Move::make($piece)->vector(0, -2);
        $this->assertTrue($move->isDirection(Direction::Down));

        $move = Move::make($piece)->vector(0, -10);
        $this->assertFalse($move->isDirection(Direction::Down));

        $move = Move::make($piece)->vector(0, 1);
        $this->assertFalse($move->isDirection(Direction::Down));

        $move = new Move($piece);
        $this->assertFalse($move->isDirection(Direction::Down));
    }

    public function testIsDirectionLeft(): void
    {
        $D4 = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->vector(-1, 0);
        $this->assertTrue($move->isDirection(Direction::Left));

        $move = Move::make($piece)->vector(-2, 0);
        $this->assertTrue($move->isDirection(Direction::Left));

        $move = Move::make($piece)->vector(-10, 0);
        $this->assertFalse($move->isDirection(Direction::Left));

        $move = Move::make($piece)->vector(1, 0);
        $this->assertFalse($move->isDirection(Direction::Left));

        $move = new Move($piece);
        $this->assertFalse($move->isDirection(Direction::Left));
    }

    public function testIsDirectionRight(): void
    {
        $D4 = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->vector(1, 0);
        $this->assertTrue($move->isDirection(Direction::Right));

        $move = Move::make($piece)->vector(2, 0);
        $this->assertTrue($move->isDirection(Direction::Right));

        $move = Move::make($piece)->vector(10, 0);
        $this->assertFalse($move->isDirection(Direction::Right));

        $move = Move::make($piece)->vector(-1, 0);
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
}
