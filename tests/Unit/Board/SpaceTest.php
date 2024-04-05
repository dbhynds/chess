<?php

namespace Tests\Unit\Board;

use App\Models\Board\Space;
use PHPUnit\Framework\TestCase;

class SpaceTest extends TestCase
{
    public function test_space_instantiates(): void
    {
        $space = new Space('A', 1);
        $this->assertInstanceOf(Space::class, $space);
    }

    public function test_has_a_row(): void
    {
        $space = new Space('A', 1);

        $this->assertEquals('A', $space->row());
    }

    public function test_has_a_column(): void
    {
        $space = new Space('A', 1);

        $this->assertEquals(1, $space->column());
    }

    public function test_has_a_name(): void
    {
        $space = new Space('A', 1);

        $this->assertEquals('A1', $space->name());
    }
}
