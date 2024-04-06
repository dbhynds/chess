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
        $this->space = new Space(Row::A, Column::i1);
    }

    public function test_instantiates(): void
    {
        $piece = new Pawn(Color::White, $this->space);
        $this->assertInstanceOf(Pawn::class, $piece);
    }

    public function test_returns_color(): void
    {
        $piece = new Pawn(Color::White, $this->space);

        $this->assertEquals(Color::White, $piece->color());
    }

    public function test_returns_space(): void
    {
        $piece = new Pawn(Color::White, $this->space);

        $this->assertEquals($this->space, $piece->space());
    }
}
