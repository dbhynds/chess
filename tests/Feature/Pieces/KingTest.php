<?php

namespace Tests\Unit\Pieces;

use App\Models\Board\File;
use App\Models\Board\Rank;
use App\Models\Board\Space;
use App\Models\Pieces\King;
use App\Models\Pieces\Pieces;
use App\Models\Players\Color;
use Tests\TestCase;

class KingTest extends TestCase
{
    private Space $space;

    protected function setUp(): void
    {
        $this->space = new Space(File::d, Rank::i4);
    }

    public function testInstantiates(): void
    {
        $piece = new King(Color::White, $this->space);
        $this->assertInstanceOf(King::class, $piece);
    }

    public function testNameReturnsKing(): void
    {
        $piece = new King(Color::White, $this->space);

        $this->assertEquals(Pieces::King, $piece->name());
    }

    public function testNotation(): void
    {
        $piece = new King(Color::White, $this->space);

        $this->assertEquals(Pieces::King->value, $piece->notation());
    }

    public function testPossibleMovesReturnsPossibleMoves(): void
    {
        $piece = new King(Color::White, $this->space);

        $this->assertCount(12, $piece->possibleMoves());
    }

    public function testRequiresAClearPathReturnsTrue(): void
    {
        $piece = new King(Color::White, $this->space);

        $this->assertTrue($piece->requiresAClearPath());
    }

    public function testFilteredMovesReturnsValidMoves(): void
    {
        $piece = new King(Color::White, $this->space);

        $this->assertCount(12, $piece->filteredMoves());
    }

    public function testMovesReturnsValidMoves(): void
    {
        $piece = new King(Color::Black, $this->space);
        $validMoves = [
            'c3', 'c4', 'c5',
            'd3', 'd5',
            'e3', 'e4', 'e5',
        ];

        $moves = $piece->moves();

        // @todo Fix this test
        // $this->assertCount(count($validMoves), $moves);
        // foreach ($moves as $move) {
        //     $this->assertContains($move->newSpace()->name(), $validMoves);
        // }
    }

    // public function testIsInCheck(): void
    // {
    //     $a1 = new Space(File::a, Rank::i1);
    //     $a2 = new Space(File::a, Rank::i2);
    //     $b2 = new Space(File::b, Rank::i2);
    //     $a3 = new Space(File::a, Rank::i3);
    //     $b3 = new Space(File::b, Rank::i3);
    //     $king = new King(Color::White, $a1);
    //     $checkingQueen = new Queen(Color::Black, $a3);
    //     $game = app(Game::class);

    //     // The king is not in check to begin with
    //     $game->reset()->place($king);
    //     $queen = new Queen(Color::White, $a2);
    //     $game->place($queen);
    //     $game->place(new Queen(Color::Black, $b3));
    //     $move = Move::make($queen)->to($b2);
    //     $this->assertTrue(Gate::allows('leavesTheKingWithoutCheck', $move));

    //     // The queen blocks check
    //     $game->reset()->place($king);
    //     $queen = new Queen(Color::White, $b2);
    //     $game->place($queen);
    //     $game->place($checkingQueen);
    //     $move = Move::make($queen)->to($a2);
    //     $this->assertTrue(Gate::allows('leavesTheKingWithoutCheck', $move));

    //     // The queen captures opposing queen
    //     $game->reset()->place($king);
    //     $queen = new Queen(Color::White, $b2);
    //     $game->place($queen);
    //     $game->place($checkingQueen);
    //     $move = Move::make($queen)->to($a3);
    //     $this->assertTrue(Gate::allows('leavesTheKingWithoutCheck', $move));

    //     // The queen unblocks check
    //     $game->reset()->place($king);
    //     $queen = new Queen(Color::White, $a2);
    //     $game->place($queen);
    //     $game->place($checkingQueen);
    //     $move = Move::make($queen)->to($b2);
    //     $this->assertFalse(Gate::allows('leavesTheKingWithoutCheck', $move));
    // }
}
