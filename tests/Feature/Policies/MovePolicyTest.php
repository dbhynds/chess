<?php

namespace Tests\Feature\Policies;

use App\Models\Board\File;
use App\Models\Board\Rank;
use App\Models\Board\Space;
use App\Models\Game\Game;
use App\Models\Game\Move\Move;
use App\Models\Pieces\King;
use App\Models\Pieces\Pawn;
use App\Models\Pieces\Queen;
use App\Models\Players\Color;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class MovePolicyTest extends TestCase
{
    public function testMovePieceToSpace(): void
    {
        $b2 = new Space(File::b, Rank::i2);
        $piece = new Pawn(Color::White, $b2);
        app(Game::class)->place($piece);

        // Move b2 to b4
        $b4 = new Space(File::b, Rank::i4);
        $move = Move::make($piece)->to($b4);
        $this->assertTrue(Gate::allows('movePieceToSpace', $move));

        // Move b2 to b8
        $b8 = new Space(File::b, Rank::i8);
        $move = Move::make($piece)->to($b8);
        $this->assertFalse(Gate::allows('movePieceToSpace', $move));

        // Queen b3 to a1
        $b3 = new Space(File::b, Rank::i3);
        $checkingQueen = new Queen(Color::Black, $b3);
        $a1 = new Space(File::a, Rank::i1);
        $move = Move::make($piece)->to($a1);
        $this->assertFalse(Gate::allows('movePieceToSpace', $move));

        // @todo test knights, castling, and en passant
    }

    public function testTravelToTheNewSpace(): void
    {
        $b2 = new Space(File::b, Rank::i2);
        $b3 = new Space(File::b, Rank::i3);
        $b4 = new Space(File::b, Rank::i4);
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
        $b2 = new Space(File::b, Rank::i2);
        $b3 = new Space(File::b, Rank::i3);
        $c3 = new Space(File::c, Rank::i3);
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

    public function testLeavesTheKingWithoutCheck(): void
    {
        $a1 = new Space(File::a, Rank::i1);
        $a2 = new Space(File::a, Rank::i2);
        $b2 = new Space(File::b, Rank::i2);
        $a3 = new Space(File::a, Rank::i3);
        $b3 = new Space(File::b, Rank::i3);
        $king = new King(Color::White, $a1);
        $checkingQueen = new Queen(Color::Black, $a3);
        $game = app(Game::class);

        // The king is not in check to begin with
        $game->reset()->place($king);
        $queen = new Queen(Color::White, $a2);
        $game->place($queen);
        $game->place(new Queen(Color::Black, $b3));
        $move = Move::make($queen)->to($b2);
        $this->assertTrue(Gate::allows('leavesTheKingWithoutCheck', $move));

        // The queen blocks check
        $game->reset()->place($king);
        $queen = new Queen(Color::White, $b2);
        $game->place($queen);
        $game->place($checkingQueen);
        $move = Move::make($queen)->to($a2);
        $this->assertTrue(Gate::allows('leavesTheKingWithoutCheck', $move));

        // The queen captures opposing queen
        $game->reset()->place($king);
        $queen = new Queen(Color::White, $b2);
        $game->place($queen);
        $game->place($checkingQueen);
        $move = Move::make($queen)->to($a3);
        $this->assertTrue(Gate::allows('leavesTheKingWithoutCheck', $move));

        // The queen unblocks check
        $game->reset()->place($king);
        $queen = new Queen(Color::White, $a2);
        $game->place($queen);
        $game->place($checkingQueen);
        $move = Move::make($queen)->to($b2);
        $this->assertFalse(Gate::allows('leavesTheKingWithoutCheck', $move));
    }
}
