<?php

namespace Tests\Unit\Pieces;

use App\Models\Board\Column;
use App\Models\Board\Row;
use App\Models\Board\Space;
use App\Models\Pieces\Pawn;
use App\Models\Players\Color;
use PHPUnit\Framework\TestCase;

class PawnTest extends TestCase
{
    private Space $space;

    protected function setUp(): void
    {
        $this->space = new Space(Row::B, Column::i1);
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

    public function test_possibleMoves_returns_possible_moves_for_white(): void
    {
        $space = new Space(Row::B, Column::i4);
        $piece = new Pawn(Color::White, $space);
        $possibleMoves = [ 'A5', 'B5', 'B6', 'C5'];

        $actual = $piece->possibleMoves();

        foreach ($actual as $move) {
            $this->assertTrue($move->isOnTheBoard());
            dump($move->newSpace()->name());
            $this->assertTrue(in_array($move->newSpace()->name(), $possibleMoves));
        }
    }
}
