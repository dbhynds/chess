<?php

namespace Tests\Feature\Pieces;

use App\Models\Board\File;
use App\Models\Board\Rank;
use App\Models\Board\Space;
use App\Models\Game\Game;
use App\Models\Game\Move\Move;
use App\Models\Pieces\Pawn;
use App\Models\Players\Color;
use Tests\TestCase;

class PawnTest extends TestCase
{
    public function testWhiteQueenPawnAndBlackKingPawnAdvanceAndWhiteCaptures(): void
    {
        $game = app(Game::class);
        $game->start();

        $d2 = new Space(File::d, Rank::i2);
        $d4 = new Space(File::d, Rank::i4);
        $e7 = new Space(File::e, Rank::i7);
        $e5 = new Space(File::e, Rank::i5);

        // d4
        $game->make(Move::make($game->pieceOn($d2))->to($d4));
        // e5
        $game->make(Move::make($game->pieceOn($e7))->to($e5));
        // dxe5
        $move = Move::make($game->pieceOn($d4))->to($e5);
        $game->make($move);

        $this->assertTrue($game->pieceOn(new Space(File::e, Rank::i5))->isWhite());
        $this->assertEquals(1, $game->capturedPieces()->count());
        $capturedPiece = $game->capturedPieces()->first();
        $this->assertInstanceOf(Pawn::class, $capturedPiece);
        $this->assertTrue($capturedPiece->isBlack());
        $this->assertTrue($capturedPiece->isCaptured());
    }

    public function testPlayer(): void
    {
        $a2 = new Space(File::a, Rank::i2);
        $pawn = new Pawn(Color::White, $a2);

        $this->assertEquals(Color::White, $pawn->player()->color());

        $a2 = new Space(File::a, Rank::i2);
        $pawn = new Pawn(Color::Black, $a2);

        $this->assertEquals(Color::Black, $pawn->player()->color());
    }

    public function testOpponent(): void
    {
        $a2 = new Space(File::a, Rank::i2);
        $pawn = new Pawn(Color::White, $a2);

        $this->assertEquals(Color::Black, $pawn->opponent()->color());

        $a2 = new Space(File::a, Rank::i2);
        $pawn = new Pawn(Color::Black, $a2);

        $this->assertEquals(Color::White, $pawn->opponent()->color());
    }
}
