<?php

namespace App\Models\Board;

use App\Models\Game\Game;
use App\Models\Pieces\Piece;

class Space
{
    public function __construct(private File $file, private Rank $rank)
    {
    }

    public function rank(): Rank
    {
        return $this->rank;
    }

    public function rankPosition(): int
    {
        return array_search($this->rank(), Board::ranks());
    }

    public function file(): File
    {
        return $this->file;
    }

    public function filePosition(): int
    {
        return array_search($this->file(), Board::files());
    }

    public static function named(Rank $rank, File $file): string
    {
        return $file->value.$rank->value;
    }

    public function name(): string
    {
        return self::named($this->rank(), $this->file());
    }

    public function isOccupied(): bool
    {
        return app(Game::class)->hasAPieceOn($this);
    }

    public function piece(): Piece
    {
        return app(Game::class)->pieceOn($this);
    }

    public function is(?Space $space): bool
    {
        return $this->name() === $space?->name();
    }
}
