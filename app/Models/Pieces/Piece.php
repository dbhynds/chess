<?php

namespace App\Models\Pieces;

use App\Models\Board\Space;
use App\Models\Game\Game;
use App\Models\Players\Color;
use App\Models\Traits\HasAColor;

abstract class Piece
{
    use HasAColor;

    private bool $isCaptured = false;

    public function __construct(private Color $color, private ?Space $space)
    {
    }

    abstract public function name(): Pieces;

    public function space(): ?Space
    {
        return $this->space;
    }

    public function isCaptured(): bool
    {
        return $this->isCaptured;
    }

    public function capture(): void
    {
        $oldSpace = $this->space();
        $this->space = null;
        $this->isCaptured = true;
        app(Game::class)->removeFromTheBoard($oldSpace, $this);
    }

    public function setSpace(Space $space): void
    {
        $this->space = $space;
    }

    public function requiresAClearPath(): bool
    {
        return true;
    }

    abstract public function possibleMoves(): array;

    abstract public function moves(): array;

    public function filteredMoves(): array
    {
        return array_filter($this->possibleMoves(), fn ($move) => $move->isOnTheBoard());
    }

    public function canCapture(Piece $piece): bool
    {
        return $this->color() !== $piece->color();
    }
}
