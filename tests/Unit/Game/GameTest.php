<?php

namespace Tests\Unit\Game;

use App\Models\Board\Board;
use App\Models\Board\Column;
use App\Models\Board\Row;
use App\Models\Board\Space;
use App\Models\Game\Game;
use App\Models\Game\Move\Move;
use App\Models\Players\Color;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function testInstantiates(): void
    {
        $game = app(Game::class);
        $this->assertInstanceOf(Game::class, $game);
    }

    public function testBoardReturnsBoard(): void
    {
        $game = app(Game::class);

        $this->assertInstanceOf(Board::class, $game->board());
    }

    public function testBlackReturnsBlack(): void
    {
        $game = app(Game::class);

        $this->assertEquals(Color::Black, $game->black()->color());
    }

    public function testWhiteReturnsWhite(): void
    {
        $game = app(Game::class);

        $this->assertEquals(Color::White, $game->white()->color());
    }

    public function testPlayersReturnsPlayers(): void
    {
        $game = app(Game::class);

        $this->assertCount(2, $game->players());
    }

    public function testActivePiecesReturnsActivePieces(): void
    {
        $game = app(Game::class);

        $this->assertEquals(16, $game->activePieces()->count());
    }

    public function testCapturedPiecesIsEmpty(): void
    {
        $game = app(Game::class);

        $this->assertEquals(0, $game->capturedPieces()->count());
    }

    public function testMoveMovesAPiece(): void
    {
        $game = app(Game::class);
        $piece = $game->activePieces()->first();
        $oldSpace = $piece->space();
        $D4 = new Space(Column::D, Row::i4);
        $move = Move::make($piece)->to($D4);

        $game->make($move);

        $this->assertArrayNotHasKey($oldSpace->name(), $game->activePieces());
        $this->assertEquals($piece, $game->activePieces()[$D4->name()]);
    }

    public function testHasAPieceOn(): void
    {
        $game = app(Game::class);

        $piece = $game->activePieces()->first();
        $this->assertTrue($game->hasAPieceOn($piece->space()));

        $D4 = new Space(Column::D, Row::i4);
        $this->assertFalse($game->hasAPieceOn($D4));
    }

    public function testPieceOn(): void
    {
        $game = app(Game::class);
        $piece = $game->activePieces()->first();

        $this->assertEquals($piece, $game->pieceOn($piece->space()));
    }
}
