<?php

namespace Tests\Unit\Players;

use App\Models\Players\Color;
use App\Models\Players\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testInstantiates(): void
    {
        $player = new Player(Color::White);
        $this->assertInstanceOf(Player::class, $player);
    }

    public function testColorReturnsColor(): void
    {
        $player = new Player(Color::White);

        $this->assertEquals(Color::White, $player->color());
    }

    public function testIsBlackReturnsTrue(): void
    {
        $player = new Player(Color::Black);

        $this->assertTrue($player->isBlack());
    }

    public function testIsBlackReturnsFalse(): void
    {
        $player = new Player(Color::White);

        $this->assertFalse($player->isBlack());
    }

    public function testIsWhiteReturnsTrue(): void
    {
        $player = new Player(Color::White);

        $this->assertTrue($player->isWhite());
    }

    public function testIsWhiteReturnsFalse(): void
    {
        $player = new Player(Color::Black);

        $this->assertFalse($player->isWhite());
    }
}
