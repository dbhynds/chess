<?php

namespace Tests\Unit\Game\Move;

use App\Models\Board\File;
use App\Models\Board\Rank;
use App\Models\Board\Space;
use App\Models\Game\Game;
use App\Models\Game\Move\Direction;
use App\Models\Game\Move\Move;
use App\Models\Pieces\King;
use App\Models\Pieces\Pawn;
use App\Models\Pieces\Queen;
use App\Models\Players\Color;
use PHPUnit\Framework\TestCase;

class MoveTest extends TestCase
{
    public function testInstantiates(): void
    {
        $h1 = new Space(File::h, Rank::i1);
        $piece = new Pawn(Color::White, $h1);
        $move = new Move($piece);

        $this->assertInstanceOf(Move::class, $move);
    }

    public function testMakeInstantiates(): void
    {
        $h1 = new Space(File::h, Rank::i1);
        $piece = new Pawn(Color::White, $h1);
        $move = Move::make($piece);

        $this->assertInstanceOf(Move::class, $move);
    }

    public function testPieceReturnsPiece(): void
    {
        $h1 = new Space(File::h, Rank::i1);
        $piece = new Pawn(Color::White, $h1);
        $move = new Move($piece);

        $actual = $move->piece();

        $this->assertEquals($piece, $actual);
    }

    public function testOriginalSpaceReturnsOriginalSpace(): void
    {
        $h1 = new Space(File::h, Rank::i1);
        $piece = new Pawn(Color::White, $h1);
        $move = new Move($piece);

        $actual = $move->originalSpace();

        $this->assertEquals($h1, $actual);
    }

    public function testNewSpaceReturnsOriginalSpaceIfNotMoved(): void
    {
        $h1 = new Space(File::h, Rank::i1);
        $piece = new Pawn(Color::White, $h1);
        $move = new Move($piece);

        $actual = $move->newSpace();

        $this->assertEquals($h1, $actual);
    }

    public function testToSetsNewSpace(): void
    {
        $h1 = new Space(File::h, Rank::i1);
        $a8 = new Space(File::a, Rank::i8);
        $piece = new Pawn(Color::White, $h1);
        $move = Move::make($piece)->to($a8);

        $this->assertEquals($a8, $move->newSpace());
    }

    public function testVectorReturnsTheSpaceAboveD4(): void
    {
        $d4 = new Space(File::d, Rank::i4);
        $piece = new Pawn(Color::White, $d4);

        $move = Move::make($piece)->withVector(0, 1);

        $this->assertEquals('d5', $move->newSpace()->name());
        $this->assertTrue($move->isOnTheBoard());
    }

    public function testVectorReturnsTheSpaceTwoAboveD4(): void
    {
        $d4 = new Space(File::d, Rank::i4);
        $piece = new Pawn(Color::White, $d4);

        $move = Move::make($piece)->withVector(0, 2);

        $this->assertEquals('d6', $move->newSpace()->name());
        $this->assertTrue($move->isOnTheBoard());
    }

    public function testVectorReturnsTheSpaceLeftOfD4(): void
    {
        $d4 = new Space(File::d, Rank::i4);
        $piece = new Pawn(Color::White, $d4);

        $move = Move::make($piece)->withVector(-1, 0);

        $this->assertEquals('c4', $move->newSpace()->name());
        $this->assertTrue($move->isOnTheBoard());
    }

    public function testVectorReturnsTheSpaceDiagonallyRightAndDownFromD4(): void
    {
        $d4 = new Space(File::d, Rank::i4);
        $piece = new Pawn(Color::White, $d4);

        $move = Move::make($piece)->withVector(1, -1);

        $this->assertEquals('e3', $move->newSpace()->name());
        $this->assertTrue($move->isOnTheBoard());
    }

    public function testVectorReturnsNullIfOffTheBoard(): void
    {
        $d4 = new Space(File::d, Rank::i4);
        $piece = new Pawn(Color::White, $d4);

        $move = Move::make($piece)->withVector(5, 5);

        $this->assertNull($move->newSpace());
        $this->assertFalse($move->isOnTheBoard());
    }

    public function testIsDirectionUp(): void
    {
        $d4 = new Space(File::d, Rank::i4);
        $piece = new Pawn(Color::White, $d4);

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
        $d4 = new Space(File::d, Rank::i4);
        $piece = new Pawn(Color::White, $d4);

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
        $d4 = new Space(File::d, Rank::i4);
        $piece = new Pawn(Color::White, $d4);

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
        $d4 = new Space(File::d, Rank::i4);
        $piece = new Pawn(Color::White, $d4);

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
        $d4 = new Space(File::d, Rank::i4);
        $d6 = new Space(File::d, Rank::i6);
        $c5 = new Space(File::c, Rank::i5);
        $e3 = new Space(File::e, Rank::i3);
        $piece = new Pawn(Color::White, $d4);

        $move = Move::make($piece)->to($d6);
        $this->assertEquals([0, 2], $move->vector());

        $move = Move::make($piece)->to($c5);
        $this->assertEquals([-1, 1], $move->vector());

        $move = Move::make($piece)->to($e3);
        $this->assertEquals([1, -1], $move->vector());
    }

    public function testPath(): void
    {
        // Piece on D4
        $d4 = new Space(File::d, Rank::i4);
        $piece = new Pawn(Color::White, $d4);

        // Bottom left to top right
        $a1 = new Space(File::a, Rank::i1);
        $b2 = new Space(File::b, Rank::i2);
        $c3 = new Space(File::c, Rank::i3);
        $e5 = new Space(File::e, Rank::i5);
        $f6 = new Space(File::f, Rank::i6);
        $g7 = new Space(File::g, Rank::i7);
        $h8 = new Space(File::h, Rank::i8);

        // Diagonal, up right
        $move = Move::make($piece)->to($h8);
        $this->assertEquals([$e5, $f6, $g7], $move->path());

        // Diagonal, down left
        $move = Move::make($piece)->to($a1);
        $this->assertEquals([$c3, $b2], $move->path());

        // Top left to bottom right
        $a7 = new Space(File::a, Rank::i7);
        $b6 = new Space(File::b, Rank::i6);
        $c5 = new Space(File::c, Rank::i5);
        $e3 = new Space(File::e, Rank::i3);
        $f2 = new Space(File::f, Rank::i2);
        $g1 = new Space(File::g, Rank::i1);

        // Diagonal, up left
        $move = Move::make($piece)->to($a7);
        $this->assertEquals([$c5, $b6], $move->path());

        // Diagonal, down right
        $move = Move::make($piece)->to($g1);
        $this->assertEquals([$e3, $f2], $move->path());

        // File 4
        $a4 = new Space(File::a, Rank::i4);
        $b4 = new Space(File::b, Rank::i4);
        $c4 = new Space(File::c, Rank::i4);
        $e4 = new Space(File::e, Rank::i4);
        $f4 = new Space(File::f, Rank::i4);
        $g4 = new Space(File::g, Rank::i4);
        $h4 = new Space(File::h, Rank::i4);

        // Up
        $move = Move::make($piece)->to($h4);
        $this->assertEquals([$e4, $f4, $g4], $move->path());

        // Down
        $move = Move::make($piece)->to($a4);
        $this->assertEquals([$c4, $b4], $move->path());

        // Rank D
        $d1 = new Space(File::d, Rank::i1);
        $d2 = new Space(File::d, Rank::i2);
        $d3 = new Space(File::d, Rank::i3);
        $d5 = new Space(File::d, Rank::i5);
        $d6 = new Space(File::d, Rank::i6);
        $d7 = new Space(File::d, Rank::i7);
        $d8 = new Space(File::d, Rank::i8);

        // Left
        $move = Move::make($piece)->to($d1);
        $this->assertEquals([$d3, $d2], $move->path());

        // Right
        $move = Move::make($piece)->to($d8);
        $this->assertEquals([$d5, $d6, $d7], $move->path());
    }

    public function testIsObstructed(): void
    {
        $b2 = new Space(File::b, Rank::i2);
        $b3 = new Space(File::b, Rank::i3);
        $b4 = new Space(File::b, Rank::i4);
        $piece = new Pawn(Color::White, $b2);
        $game = app(Game::class);
        // Ensure the same instance always gets resolved
        app()->instance(Game::class, $game);

        // Place a piece with no blockers
        $game->place($piece);
        $move = Move::make($piece)->to($b4);
        $this->assertFalse($move->isObstructed());

        // Now add a blocker
        $blocker = new Pawn(Color::White, $b3);
        $game->place($blocker);
        $move = Move::make($piece)->to($b4);
        $this->assertTrue($move->isObstructed());

        // @todo test pieces that don't require a clear path
    }

    public function testIsCastling(): void
    {
        $c1 = new Space(File::c, Rank::i1);
        $e1 = new Space(File::e, Rank::i1);
        $g1 = new Space(File::g, Rank::i1);
        $piece = new King(Color::White, $e1);

        $move = Move::make($piece)->to($g1);
        $this->assertTrue($move->isCastling());

        $move = Move::make($piece)->to($c1);
        $this->assertTrue($move->isCastling());

        $c8 = new Space(File::c, Rank::i8);
        $e8 = new Space(File::e, Rank::i8);
        $g8 = new Space(File::g, Rank::i8);
        $piece = new King(Color::Black, $e8);

        $move = Move::make($piece)->to($g8);
        $this->assertTrue($move->isCastling());

        $move = Move::make($piece)->to($c8);
        $this->assertTrue($move->isCastling());

        $d1 = new Space(File::d, Rank::i1);
        $move = Move::make($piece)->to($d1);
        $this->assertFalse($move->isCastling());

        $piece = new Pawn(Color::White, $e1);
        $move = Move::make($piece)->to($g1);
        $this->assertFalse($move->isCastling());
    }

    public function testNotationForCastling(): void
    {
        $c1 = new Space(File::c, Rank::i1);
        $e1 = new Space(File::e, Rank::i1);
        $g1 = new Space(File::g, Rank::i1);
        $piece = new King(Color::White, $e1);

        $move = Move::make($piece)->to($g1);
        $this->assertEquals('O-O', $move->notation());

        $move = Move::make($piece)->to($c1);
        $this->assertEquals('O-O-O', $move->notation());
    }

    public function testNotationForPromotion(): void
    {
        // @todo
    }

    public function testNotationForMajorPieces(): void
    {
        $b2 = new Space(File::b, Rank::i2);
        $a3 = new Space(File::a, Rank::i3);
        $b3 = new Space(File::b, Rank::i3);
        $b4 = new Space(File::b, Rank::i4);
        $c3 = new Space(File::c, Rank::i3);

        $game = app(Game::class);
        // Ensure the same instance always gets resolved
        app()->instance(Game::class, $game);

        // Place a piece
        $piece = new Queen(Color::White, $b2);
        $game->place($piece);

        // Up one
        $move = Move::make($piece)->to($b3);
        $this->assertEquals('Qb3', $move->notation());

        // Capture
        $opponent = new Queen(Color::Black, $a3);
        $game->place($opponent);
        $move = Move::make($piece)->to($a3);
        $this->assertEquals('Qxa3', $move->notation());
    }

    public function testNotationForPawns(): void
    {
        $b2 = new Space(File::b, Rank::i2);
        $a3 = new Space(File::a, Rank::i3);
        $b3 = new Space(File::b, Rank::i3);
        $b4 = new Space(File::b, Rank::i4);
        $c3 = new Space(File::c, Rank::i3);

        $game = app(Game::class);
        // Ensure the same instance always gets resolved
        app()->instance(Game::class, $game);

        // Place a piece
        $piece = new Pawn(Color::White, $b2);
        $game->place($piece);

        // Up one
        $move = Move::make($piece)->to($b3);
        $this->assertEquals('b3', $move->notation());

        // Up one
        $move = Move::make($piece)->to($b4);
        $this->assertEquals('b4', $move->notation());

        // Capture
        $opponent = new Pawn(Color::Black, $a3);
        $game->place($opponent);
        $move = Move::make($piece)->to($a3);
        $this->assertEquals('bxa3', $move->notation());
    }
}
