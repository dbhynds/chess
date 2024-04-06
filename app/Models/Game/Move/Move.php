<?php

namespace App\Models\Game\Move;

use App\Models\Board\Board;
use App\Models\Board\Space;
use App\Models\Pieces\Piece;

class Move
{
    private ?Space $newSpace;

    public function __construct(private Piece $piece)
    {
        return $this->newSpace = $this->originalSpace();
    }

    public static function make(Piece $piece): self
    {
        return new self($piece);
    }

    public function piece(): Piece
    {
        return $this->piece;
    }

    public function originalSpace(): Space
    {
        return $this->piece()->space();
    }

    public function newSpace(): ?Space
    {
        return $this->newSpace;
    }

    public function isOnTheBoard(): bool
    {
        return isset($this->newSpace);
    }

    public function left(?int $distance = 1): self
    {
        if ($this->newSpace() === null) {
            return $this;
        }

        $position = array_search($this->newSpace()->column(), Board::columns());
        $newPosition = self::newPosition($position, $distance);

        if (! self::isAPosition($newPosition)) {
            $this->newSpace = null;
        } else {
            $this->newSpace = app(Board::class)->space($this->newSpace()->row(), Board::columns()[$newPosition]);
        }

        return $this;
    }

    public function right(?int $distance = 1): self
    {
        return $this->left(-$distance);
    }

    public function down(?int $distance = 1): self
    {
        if ($this->newSpace() === null) {
            return $this;
        }

        $position = array_search($this->newSpace()->row(), Board::rows());
        $newPosition = self::newPosition($position, $distance);

        if (! self::isAPosition($newPosition)) {
            $this->newSpace = null;
        } else {
            $this->newSpace = app(Board::class)->space(Board::rows()[$newPosition], $this->newSpace()->column());
        }

        return $this;
    }

    public function up(?int $distance = 1): self
    {
        return $this->down(-$distance);
    }

    private static function newPosition(int $position, int $distance): int
    {
        return $position - $distance;
    }

    private static function isAPosition(int $position): bool
    {
        return $position >= 0 && $position < 8;
    }
}
