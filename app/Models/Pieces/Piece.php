<?php

namespace App\Models\Pieces;

use App\Models\Board\Space;
use App\Models\Game\Game;
use App\Models\Game\Move\Move;
use App\Models\Players\Color;
use App\Models\Players\Player;
use App\Models\Traits\HasAColor;

abstract class Piece
{
    use HasAColor;

    private bool $isCaptured = false;

    public function __construct(private Color $color, private ?Space $space)
    {
    }

    public function clone(): static
    {
        return new static($this->color, $this->space);
    }

    abstract public function name(): Pieces;

    final public function notation(): string
    {
        return $this->name()->value;
    }

    final public function space(): ?Space
    {
        return $this->space;
    }

    final public function isCaptured(): bool
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

    final public function setSpace(Space $space): void
    {
        $this->space = $space;
    }

    public function requiresAClearPath(): bool
    {
        return true;
    }

    abstract public function possibleMoves(): array;

    public function moves(): array
    {
        return $this->filteredMoves();
    }

    final public function filteredMoves(): array
    {
        return array_filter($this->possibleMoves(), fn (Move $move) => $move->isOnTheBoard());
    }

    final public function player(bool $isSelf = true): Player
    {
        if ($this->color() === Color::White xor ! $isSelf) {
            return app(Game::class)->white();
        } else {
            return app(Game::class)->black();
        }
    }

    final public function opponent(): Player
    {
        return $this->player(false);
    }

    public function canCapture(Piece $piece): bool
    {
        return $this->color() !== $piece->color();
    }

    public function isPieceOn(Piece $piece, Space $space): bool
    {
        return $this->color() === $piece->color()
            && $this->name() === $piece->name()
            && $this->space()->name() === $space->name();
    }
}
