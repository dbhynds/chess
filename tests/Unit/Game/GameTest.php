<?php

namespace Tests\Unit\Game;

use App\Models\Board\Board;
use App\Models\Board\File;
use App\Models\Board\Rank;
use App\Models\Board\Space;
use App\Models\Game\Game;
use App\Models\Game\Move\Move;
use App\Models\Players\Color;
use Illuminate\Support\Facades\Gate;
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

    public function testStart(): void
    {
        $game = app(Game::class)->start();

        $this->assertEquals(32, $game->activePieces()->count());
        $this->assertEquals(0, $game->capturedPieces()->count());
        $this->assertEquals(Color::White, $game->currentTurn()->color());
    }

    public function testReset(): void
    {
        $game = app(Game::class)->start();
        $game->activePieces()->first()->capture();

        $game->reset();

        $this->assertEquals(0, $game->activePieces()->count());
        $this->assertEquals(0, $game->capturedPieces()->count());
    }

    public function testActivePiecesReturnsActivePieces(): void
    {
        $game = app(Game::class)->start();

        $this->assertEquals(32, $game->activePieces()->count());
    }

    public function testCapturedPiecesIsEmpty(): void
    {
        $game = app(Game::class)->start();

        $this->assertEquals(0, $game->capturedPieces()->count());
    }

    public function testMoveMovesAPiece(): void
    {
        $game = app(Game::class)->start();
        $piece = $game->activePieces()->first();
        $oldSpace = $piece->space();
        $d4 = new Space(File::d, Rank::i4);
        $move = Move::make($piece)->to($d4);
        Gate::shouldReceive('authorize')
            ->once()
            ->with('can', $move)
            ->andReturn(true);

        $game->make($move);

        $this->assertArrayNotHasKey($oldSpace->name(), $game->activePieces());
        $this->assertEquals($piece, $game->activePieces()[$d4->name()]);
    }

    public function testHasAPieceOn(): void
    {
        $game = app(Game::class)->start();

        $piece = $game->activePieces()->first();
        $this->assertTrue($game->hasAPieceOn($piece->space()));

        $d4 = new Space(File::d, Rank::i4);
        $this->assertFalse($game->hasAPieceOn($d4));
    }

    public function testPieceOn(): void
    {
        $game = app(Game::class)->start();
        $piece = $game->activePieces()->first();

        $this->assertEquals($piece, $game->pieceOn($piece->space()));
    }
}
