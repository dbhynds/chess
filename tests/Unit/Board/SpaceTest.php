<?php

namespace Tests\Unit\Board;

use App\Models\Board\Column;
use App\Models\Board\Row;
use App\Models\Board\Space;
use PHPUnit\Framework\TestCase;

class SpaceTest extends TestCase
{
    public function testSpaceInstantiates(): void
    {
        $space = new Space(Column::A, Row::i1);
        $this->assertInstanceOf(Space::class, $space);
    }

    public function testHasARow(): void
    {
        $space = new Space(Column::A, Row::i1);

        $this->assertEquals(Row::i1, $space->row());
    }

    public function testHasAColumn(): void
    {
        $space = new Space(Column::A, Row::i1);

        $this->assertEquals(Column::A, $space->column());
    }

    public function testHasAName(): void
    {
        $space = new Space(Column::A, Row::i1);

        $this->assertEquals('A1', $space->name());
    }

    public function testRowPositionReturnsRow(): void
    {
        $space = new Space(Column::A, Row::i1);

        $this->assertEquals(0, $space->rowPosition());

        $space = new Space(Column::A, Row::i8);

        $this->assertEquals(7, $space->rowPosition());
    }

    public function testColumnPositionReturnsColumn(): void
    {
        $space = new Space(Column::A, Row::i1);

        $this->assertEquals(0, $space->columnPosition());

        $space = new Space(Column::H, Row::i1);

        $this->assertEquals(7, $space->columnPosition());
    }
}
