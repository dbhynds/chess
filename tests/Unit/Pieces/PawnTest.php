<?php

namespace Tests\Unit\Pieces;

use App\Models\Board\Space;
use App\Models\Pieces\Pawn;
use App\Models\Players\Color;
use PHPUnit\Framework\TestCase;

class PawnTest extends TestCase
{
    private Space $space;

    protected function setUp(): void
    {
        $this->space = new Space('A', 1);
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

    public function test_is_on_A1(): void
    {
        $piece = new Pawn(Color::White, $this->space);

        $this->assertTrue($piece->isOn($this->space));
    }

    public function test_is_not_on_A1(): void
    {
        $space = new Space('H', 8);
        $piece = new Pawn(Color::White, $this->space);

        $this->assertFalse($piece->isOn($space));
    }
}
