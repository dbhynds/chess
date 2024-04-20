<?php

namespace Tests\Unit\Board;

use App\Models\Board\File;
use App\Models\Board\Rank;
use App\Models\Board\Space;
use PHPUnit\Framework\TestCase;

class SpaceTest extends TestCase
{
    public function testSpaceInstantiates(): void
    {
        $space = new Space(File::a, Rank::i1);
        $this->assertInstanceOf(Space::class, $space);
    }

    public function testHasARank(): void
    {
        $space = new Space(File::a, Rank::i1);

        $this->assertEquals(Rank::i1, $space->rank());
    }

    public function testHasAFile(): void
    {
        $space = new Space(File::a, Rank::i1);

        $this->assertEquals(File::a, $space->file());
    }

    public function testHasAName(): void
    {
        $space = new Space(File::a, Rank::i1);

        $this->assertEquals('a1', $space->name());
    }

    public function testRankPositionReturnsRank(): void
    {
        $space = new Space(File::a, Rank::i1);

        $this->assertEquals(0, $space->rankPosition());

        $space = new Space(File::a, Rank::i8);

        $this->assertEquals(7, $space->rankPosition());
    }

    public function testFilePositionReturnsFile(): void
    {
        $space = new Space(File::a, Rank::i1);

        $this->assertEquals(0, $space->filePosition());

        $space = new Space(File::h, Rank::i1);

        $this->assertEquals(7, $space->filePosition());
    }
}
