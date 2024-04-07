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

    public function to(Space $space): self
    {
        $this->newSpace = $space;

        return $this;
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

    public function vector(int $x, int $y): self
    {
        $newX = $this->originalSpace()->columnPosition() + $x;
        $newY = $this->originalSpace()->rowPosition() + $y;

        if (! self::isAPosition($newX, $newY)) {
            $this->newSpace = null;
        } else {
            $this->newSpace = app(Board::class)->space(Board::rows()[$newY], Board::columns()[$newX]);
        }

        return $this;
    }

    public function isDirection(Direction $direction, ?int $magnitude = null): bool
    {
        if (! $this->isOnTheBoard()) {
            return false;
        }

        $originalY = $this->originalSpace()->rowPosition();
        $originalX = $this->originalSpace()->columnPosition();
        $newY = $this->newSpace()->rowPosition();
        $newX = $this->newSpace()->columnPosition();

        switch ($direction) {
            case Direction::Up:
                if (isset($count)) {
                    return $newY - $count === $originalY;
                }

                return $originalY < $newY;
            case Direction::Down:
                if (isset($count)) {
                    return $newY + $count === $originalY;
                }

                return $originalY > $newY;
            case Direction::Left:
                if (isset($count)) {
                    return $newX + $count === $originalX;
                }

                return $originalX > $newX;
            case Direction::Right:
                if (isset($count)) {
                    return $newX - $count === $originalX;
                }

                return $originalX < $newX;
            default:
                return false;
        }
    }

    public function capturesAPiece(): bool
    {
        return false;
    }

    public function capturedPiece(): ?Piece
    {
        return null;
    }

    private static function isAPosition(int $newX, int $newY): bool
    {
        return $newX >= 0 && $newX < 8
            && $newY >= 0 && $newY < 8;
    }
}
