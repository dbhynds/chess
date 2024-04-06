<?php

namespace Tests\Unit\Players;

use App\Models\Players\Color;
use App\Models\Players\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function test_instantiates(): void
    {
        $player = new Player(Color::White);
        $this->assertInstanceOf(Player::class, $player);
    }

    public function test_color_returns_color(): void
    {
        $player = new Player(Color::White);

        $this->assertEquals(Color::White, $player->color());
    }

    public function test_isBlack_returns_true(): void
    {
        $player = new Player(Color::Black);

        $this->assertTrue($player->isBlack());
    }

    public function test_isBlack_returns_false(): void
    {
        $player = new Player(Color::White);

        $this->assertFalse($player->isBlack());
    }

    public function test_isWhite_returns_true(): void
    {
        $player = new Player(Color::White);

        $this->assertTrue($player->isWhite());
    }

    public function test_isWhite_returns_false(): void
    {
        $player = new Player(Color::Black);

        $this->assertFalse($player->isWhite());
    }
}
