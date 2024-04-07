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

    public function test_instantiates(): void
    {
        $piece = new Pawn(Color::White, $this->space);
        $this->assertInstanceOf(Pawn::class, $piece);
    }

    public function test_color_returns_color(): void
    {
        $piece = new Pawn(Color::White, $this->space);

        $this->assertEquals(Color::White, $piece->color());
    }

    public function test_space_returns_space(): void
    {
        $piece = new Pawn(Color::White, $this->space);

        $this->assertEquals($this->space, $piece->space());
    }

    public function test_setSpace_sets_a_new_space(): void
    {
        $B2 = new Space(Column::B, Row::i2);
        $C2 = new Space(Column::C, Row::i2);
        $piece = new Pawn(Color::White, $this->space);

        $piece->setSpace($C2);

        $this->assertEquals($C2, $piece->space());
    }

    public function test_name_returns_pawn(): void
    {
        $piece = new Pawn(Color::White, $this->space);

        $this->assertEquals(Pieces::Pawn, $piece->name());
    }

    public function test_possibleMoves_returns_possible_moves_for_white(): void
    {
        $piece = new Pawn(Color::White, $this->space);

        $this->assertCount(8, $piece->possibleMoves());
    }

    public function test_requiresAClearPath_returns_true(): void
    {
        $piece = new Pawn(Color::White, $this->space);

        $this->assertTrue($piece->requiresAClearPath());
    }

    public function test_filteredMoves_returns_valid_moves(): void
    {
        $space = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $space);

        $this->assertCount(8, $piece->filteredMoves());
    }

    public function test_moveIsValidForThisColor_returns_true_for_white_up(): void
    {
        $space = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $space);
        $move = Move::make($piece)->vector(0, 1);

        $this->assertTrue($piece->moveIsValidForThisColor($move));
    }

    public function test_moveIsValidForThisColor_returns_false_for_white_down(): void
    {
        $space = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::White, $space);
        $move = Move::make($piece)->vector(0, -1);

        $this->assertFalse($piece->moveIsValidForThisColor($move));
    }

    public function test_moveIsValidForThisColor_returns_true_for_black_down(): void
    {
        $space = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::Black, $space);
        $move = Move::make($piece)->vector(0, -1);

        $this->assertTrue($piece->moveIsValidForThisColor($move));
    }

    public function test_moveIsValidForThisColor_returns_false_for_black_up(): void
    {
        $space = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::Black, $space);
        $move = Move::make($piece)->vector(0, 1);

        $this->assertFalse($piece->moveIsValidForThisColor($move));
    }

    public function test_moves_returns_valid_moves_for_white(): void
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

    public function test_moves_returns_no_valid_moves_for_white_at_end_of_the_board(): void
    {
        $space = new Space(Column::D, Row::i8);
        $piece = new Pawn(Color::White, $space);

        $moves = $piece->moves();

        $this->assertCount(0, $moves);
    }

    public function test_moves_returns_valid_moves_for_black(): void
    {
        $space = new Space(Column::D, Row::i4);
        $piece = new Pawn(Color::Black, $space);
        $validMoves = ['C3', 'D3', 'D2', 'E3'];

        $moves = $piece->moves();

        $this->assertCount(4, $moves);
        foreach ($moves as $move) {
            $this->assertContains($move->newSpace()->name(), $validMoves);
        }
    }
}
