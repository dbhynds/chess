<?php

namespace Tests\Feature\MovePolicy;

use App\Models\Board\Column;
use App\Models\Board\Row;
use App\Models\Board\Space;
use App\Models\Game\Game;
use App\Models\Game\Move\Move;
use App\Models\Pieces\Pawn;
use App\Models\Players\Color;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class MovePolicyTest extends TestCase
{
    public function testMovePieceToSpace(): void
    {
        $B2 = new Space(Column::B, Row::i2);
        $piece = new Pawn(Color::White, $B2);
        app(Game::class)->place($piece);

        // Move b2 to b4
        $B4 = new Space(Column::B, Row::i4);
        $move = Move::make($piece)->to($B4);
        $this->assertTrue(Gate::allows('movePieceToSpace', $move));

        // Move b2 to b8
        $B8 = new Space(Column::B, Row::i8);
        $move = Move::make($piece)->to($B8);
        $this->assertFalse(Gate::allows('movePieceToSpace', $move));

        // @todo test knights, castling, and en passant
    }

    public function testTravelToTheNewSpace(): void
    {
        $B2 = new Space(Column::B, Row::i2);
        $B3 = new Space(Column::B, Row::i3);
        $B4 = new Space(Column::B, Row::i4);
        $piece = new Pawn(Color::White, $B2);
        $game = app(Game::class);

        // Place a piece with no blockers
        $game->place($piece);
        $move = Move::make($piece)->to($B4);
        $this->assertTrue(Gate::allows('travelToTheNewSpace', $move));

        // Now add a blocker
        $blocker = new Pawn(Color::White, $B3);
        $game->place($blocker);
        $move = Move::make($piece)->to($B4);
        $this->assertFalse(Gate::allows('travelToTheNewSpace', $move));

        // @todo test knights, castling, and en passant
    }

    public function testOccupyTheNewSpace(): void
    {
        $B2 = new Space(Column::B, Row::i2);
        $B3 = new Space(Column::B, Row::i3);
        $C3 = new Space(Column::C, Row::i3);
        $piece = new Pawn(Color::White, $B2);
        $game = app(Game::class);
        $game->place($piece);

        // The target space is not occupied
        $move = Move::make($piece)->to($B3);
        $this->assertTrue(Gate::allows('occupyTheNewSpace', $move));

        // A friendly piece cannot be captured
        $friendly = new Pawn(Color::White, $C3);
        $game->place($friendly);
        $move = Move::make($piece)->to($C3);
        $this->assertFalse(Gate::allows('occupyTheNewSpace', $move));

        // Capture the opponent
        $opponent = new Pawn(Color::Black, $C3);
        $game->place($opponent);
        $move = Move::make($piece)->to($C3);
        $this->assertTrue(Gate::allows('occupyTheNewSpace', $move));
    }
}
