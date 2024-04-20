<?php

namespace Tests\Feature\MovePolicy;

use App\Models\Board\File;
use App\Models\Board\Rank;
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
        $b2 = new Space(File::B, Rank::i2);
        $piece = new Pawn(Color::White, $b2);
        app(Game::class)->place($piece);

        // Move b2 to b4
        $b4 = new Space(File::B, Rank::i4);
        $move = Move::make($piece)->to($b4);
        $this->assertTrue(Gate::allows('movePieceToSpace', $move));

        // Move b2 to b8
        $b8 = new Space(File::B, Rank::i8);
        $move = Move::make($piece)->to($b8);
        $this->assertFalse(Gate::allows('movePieceToSpace', $move));

        // @todo test knights, castling, and en passant
    }

    public function testTravelToTheNewSpace(): void
    {
        $b2 = new Space(File::B, Rank::i2);
        $b3 = new Space(File::B, Rank::i3);
        $b4 = new Space(File::B, Rank::i4);
        $piece = new Pawn(Color::White, $b2);
        $game = app(Game::class);

        // Place a piece with no blockers
        $game->place($piece);
        $move = Move::make($piece)->to($b4);
        $this->assertTrue(Gate::allows('travelToTheNewSpace', $move));

        // Now add a blocker
        $blocker = new Pawn(Color::White, $b3);
        $game->place($blocker);
        $move = Move::make($piece)->to($b4);
        $this->assertFalse(Gate::allows('travelToTheNewSpace', $move));

        // @todo test knights, castling, and en passant
    }

    public function testOccupyTheNewSpace(): void
    {
        $b2 = new Space(File::B, Rank::i2);
        $b3 = new Space(File::B, Rank::i3);
        $c3 = new Space(File::C, Rank::i3);
        $piece = new Pawn(Color::White, $b2);
        $game = app(Game::class);
        $game->place($piece);

        // The target space is not occupied
        $move = Move::make($piece)->to($b3);
        $this->assertTrue(Gate::allows('occupyTheNewSpace', $move));

        // A friendly piece cannot be captured
        $friendly = new Pawn(Color::White, $c3);
        $game->place($friendly);
        $move = Move::make($piece)->to($c3);
        $this->assertFalse(Gate::allows('occupyTheNewSpace', $move));

        // Capture the opponent
        $opponent = new Pawn(Color::Black, $c3);
        $game->place($opponent);
        $move = Move::make($piece)->to($c3);
        $this->assertTrue(Gate::allows('occupyTheNewSpace', $move));
    }
}
