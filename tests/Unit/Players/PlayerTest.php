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

    public function test_returns_color(): void
    {
        $player = new Player(Color::White);

        $this->assertEquals(Color::White, $player->color());
    }
}
