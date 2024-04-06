<?php

namespace Tests\Unit\Game\Move;

use App\Models\Board\Board;
use App\Models\Board\Column;
use App\Models\Board\Row;
use App\Models\Board\Space;
use App\Models\Game\Move\Move;
use App\Models\Pieces\Pawn;
use App\Models\Players\Color;
use PHPUnit\Framework\TestCase;

class MoveTest extends TestCase
{
    public function test_instantiates(): void
    {
        $A8 = new Space(Row::A, Column::i8);
        $piece = new Pawn(Color::White, $A8);
        $move = new Move($piece);

        $this->assertInstanceOf(Move::class, $move);
    }

    public function test_make_instantiates(): void
    {
        $A8 = new Space(Row::A, Column::i8);
        $piece = new Pawn(Color::White, $A8);
        $move = Move::make($piece);

        $this->assertInstanceOf(Move::class, $move);
    }

    public function test_piece_returns_piece(): void
    {
        $A8 = new Space(Row::A, Column::i8);
        $piece = new Pawn(Color::White, $A8);
        $move = new Move($piece);

        $actual = $move->piece();

        $this->assertEquals($piece, $actual);
    }

    public function test_originalSpace_returns_original_space(): void
    {
        $A8 = new Space(Row::A, Column::i8);
        $piece = new Pawn(Color::White, $A8);
        $move = new Move($piece);

        $actual = $move->originalSpace();

        $this->assertEquals($A8, $actual);
    }

    public function test_newSpace_returns_original_space_if_not_moved(): void
    {
        $A8 = new Space(Row::A, Column::i8);
        $piece = new Pawn(Color::White, $A8);
        $move = new Move($piece);

        $actual = $move->newSpace();

        $this->assertEquals($A8, $actual);
    }

    public function test_left_returns_the_space_to_the_left_of_A8(): void
    {
        $A8 = new Space(Row::A, Column::i8);
        $piece = new Pawn(Color::White, $A8);
        $move = new Move($piece);

        $move->left();

        $this->assertEquals('A7', $move->newSpace()->name());
    }

    public function test_left_returns_the_space_7_to_the_left_of_A8(): void
    {
        $A8 = new Space(Row::A, Column::i8);
        $piece = new Pawn(Color::White, $A8);
        $move = new Move($piece);

        $move->left(7);

        $this->assertEquals('A1', $move->newSpace()->name());
    }

    public function test_left_returns_null_if_off_the_board(): void
    {
        $A8 = new Space(Row::A, Column::i8);
        $piece = new Pawn(Color::White, $A8);
        $move = new Move($piece);

        $move->left(8);

        $this->assertNull($move->newSpace());
    }

    public function test_right_returns_the_space_to_the_left_of_A8(): void
    {
        $A1 = new Space(Row::A, Column::i1);
        $piece = new Pawn(Color::White, $A1);
        $move = new Move($piece);

        $move->right();

        $this->assertEquals('A2', $move->newSpace()->name());
    }

    public function test_right_returns_the_space_7_to_the_left_of_A8(): void
    {
        $A1 = new Space(Row::A, Column::i1);
        $piece = new Pawn(Color::White, $A1);
        $move = new Move($piece);

        $move->right(7);

        $this->assertEquals('A8', $move->newSpace()->name());
    }

    public function test_right_returns_null_if_off_the_board(): void
    {
        $A1 = new Space(Row::A, Column::i1);
        $piece = new Pawn(Color::White, $A1);
        $move = new Move($piece);

        $move->right(8);

        $this->assertNull($move->newSpace());
    }

    public function test_left_chains(): void
    {
        $A8 = new Space(Row::A, Column::i8);
        $piece = new Pawn(Color::White, $A8);
        $move = new Move($piece);

        $move->left()->left()->left()->left()->left()->left()->left();

        $this->assertEquals('A1', $move->newSpace()->name());
    }

    public function test_left_chains_off_the_board(): void
    {
        $A8 = new Space(Row::A, Column::i8);
        $piece = new Pawn(Color::White, $A8);
        $move = new Move($piece);

        $move->left(8)->left();

        $this->assertNull($move->newSpace());
    }

    public function test_isOnTheBoard_returns_true(): void
    {
        $A8 = new Space(Row::A, Column::i8);
        $piece = new Pawn(Color::White, $A8);
        $move = new Move($piece);

        $this->assertTrue($move->isOnTheBoard());
    }

    public function test_isOnTheBoard_returns_false(): void
    {
        $A8 = new Space(Row::A, Column::i8);
        $piece = new Pawn(Color::White, $A8);
        $move = new Move($piece);

        $move->left(8);

        $this->assertFalse($move->isOnTheBoard());
    }
}
