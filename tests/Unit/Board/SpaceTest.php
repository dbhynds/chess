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
        $space = new Space(Column::A, Row::i1);
        $this->assertInstanceOf(Space::class, $space);
    }

    public function test_has_a_row(): void
    {
        $space = new Space(Column::A, Row::i1);

        $this->assertEquals(Row::i1, $space->row());
    }

    public function test_has_a_column(): void
    {
        $space = new Space(Column::A, Row::i1);

        $this->assertEquals(Column::A, $space->column());
    }

    public function test_has_a_name(): void
    {
        $space = new Space(Column::A, Row::i1);

        $this->assertEquals('A1', $space->name());
    }

    public function test_row_position_returns_row(): void
    {
        $space = new Space(Column::A, Row::i1);

        $this->assertEquals(0, $space->rowPosition());

        $space = new Space(Column::A, Row::i8);

        $this->assertEquals(7, $space->rowPosition());
    }

    public function test_column_position_returns_column(): void
    {
        $space = new Space(Column::A, Row::i1);

        $this->assertEquals(0, $space->columnPosition());

        $space = new Space(Column::H, Row::i1);

        $this->assertEquals(7, $space->columnPosition());
    }
}
