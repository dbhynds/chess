<?php

namespace Tests\Feature\Pieces;

use App\Models\Board\Column;
use App\Models\Board\Row;
use App\Models\Board\Space;
use App\Models\Game\Move\Move;
use App\Models\Game\Game;
use App\Models\Pieces\Pawn;
use App\Models\Pieces\Pieces;
use App\Models\Players\Color;
use Tests\TestCase;

class PawnTest extends TestCase
{
    public function testWhiteQueenPawnAndBlackKingPawnAdvanceAndWhiteCaptures(): void
    {
        $game = app(Game::class);

        $D2 = new Space(Column::D, Row::i2);
        $D4 = new Space(Column::D, Row::i4);
        $E7 = new Space(Column::E, Row::i7);
        $E5 = new Space(Column::E, Row::i5);
        
        // d4
        $game->make(Move::make($game->pieceOn($D2))->to($D4));
        // e5
        $game->make(Move::make($game->pieceOn($E7))->to($E5));
        // dxe5
        $move = Move::make($game->pieceOn($D4))->to($E5);
        $game->make($move);

        $this->assertTrue($game->pieceOn(new Space(Column::E, Row::i5))->isWhite());
        $this->assertEquals(1, $game->capturedPieces()->count());
        $capturedPiece = $game->capturedPieces()->first();
        $this->assertInstanceOf(Pawn::class, $capturedPiece);
        $this->assertTrue($capturedPiece->isBlack());
        $this->assertTrue($capturedPiece->isCaptured());
    }
}
