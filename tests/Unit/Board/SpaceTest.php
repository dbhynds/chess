<?php

namespace Tests\Unit\Board;

use App\Models\Board\Column;
use App\Models\Board\Row;
use App\Models\Board\Space;
use PHPUnit\Framework\TestCase;

class SpaceTest extends TestCase
{
    public function test_space_instantiates(): void
    {
        $space = new Space(Row::A, Column::i1);
        $this->assertInstanceOf(Space::class, $space);
    }

    public function test_has_a_row(): void
    {
        $space = new Space(Row::A, Column::i1);

        $this->assertEquals(Row::A, $space->row());
    }

    public function test_has_a_column(): void
    {
        $space = new Space(Row::A, Column::i1);

        $this->assertEquals(Column::i1, $space->column());
    }

    public function test_has_a_name(): void
    {
        $space = new Space(Row::A, Column::i1);

        $this->assertEquals('A1', $space->name());
    }
}
