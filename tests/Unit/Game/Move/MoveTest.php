<?php

namespace Tests\Unit\Game\Move;

use App\Models\Board\Column;
use App\Models\Board\Row;
use App\Models\Board\Space;
use App\Models\Game\Move\Direction;
use App\Models\Game\Move\Move;
use App\Models\Pieces\Pawn;
use App\Models\Players\Color;
use PHPUnit\Framework\TestCase;

class MoveTest extends TestCase
{
    public function test_instantiates(): void
    {
        $H1 = new Space(Column::H, Row::i1);
        $piece = new Pawn(Color::White, $H1);
        $move = new Move($piece);

        $this->assertInstanceOf(Move::class, $move);
    }

    public function test_make_instantiates(): void
    {
        $H1 = new Space(Column::H, Row::i1);
        $piece = new Pawn(Color::White, $H1);
        $move = Move::make($piece);

        $this->assertInstanceOf(Move::class, $move);
    }

    public function test_piece_returns_piece(): void
    {
        $H1 = new Space(Column::H, Row::i1);
        $piece = new Pawn(Color::White, $H1);
        $move = new Move($piece);

        $actual = $move->piece();

        $this->assertEquals($piece, $actual);
    }

    public function test_originalSpace_returns_original_space(): void
    {
        $H1 = new Space(Column::H, Row::i1);
        $piece = new Pawn(Color::White, $H1);
        $move = new Move($piece);

        $actual = $move->originalSpace();

        $this->assertEquals($H1, $actual);
    }

    public function test_newSpace_returns_original_space_if_not_moved(): void
    {
        $H1 = new Space(Column::H, Row::i1);
        $piece = new Pawn(Color::White, $H1);
        $move = new Move($piece);

        $actual = $move->newSpace();

        $this->assertEquals($H1, $actual);
    }

    public function test_to_sets_new_space(): void
    {
        $H1 = new Space(Column::H, Row::i1);
        $A8 = new Space(Column::A, Row::i8);
        $piece = new Pawn(Color::White, $H1);
        $move = Move::make($piece)->to($A8);

        $this->assertEquals($A8, $move->newSpace());
    }

    public function test_vector_returns_the_space_above_D4(): void
    {
        $D4 = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->vector(0, 1);

        $this->assertEquals('D5', $move->newSpace()->name());
        $this->assertTrue($move->isOnTheBoard());
    }

    public function test_vector_returns_the_space_two_above_D4(): void
    {
        $D4 = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->vector(0, 2);

        $this->assertEquals('D6', $move->newSpace()->name());
        $this->assertTrue($move->isOnTheBoard());
    }

    public function test_vector_returns_the_space_left_of_D4(): void
    {
        $D4 = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->vector(-1, 0);

        $this->assertEquals('C4', $move->newSpace()->name());
        $this->assertTrue($move->isOnTheBoard());
    }

    public function test_vector_returns_the_space_diagonally_right_and_down_from_D4(): void
    {
        $D4 = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->vector(1, -1);

        $this->assertEquals('E3', $move->newSpace()->name());
        $this->assertTrue($move->isOnTheBoard());
    }

    public function test_vector_returns_null_if_off_the_board(): void
    {
        $D4 = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $D4);

        $move = Move::make($piece)->vector(5, 5);

        $this->assertNull($move->newSpace());
        $this->assertFalse($move->isOnTheBoard());
    }

    public function test_isDirection_up(): void
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

    public function test_isDirection_down(): void
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

    public function test_isDirection_left(): void
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

    public function test_isDirection_right(): void
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
}
