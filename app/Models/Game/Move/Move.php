<?php

namespace App\Models\Game\Move;

use App\Models\Board\Board;
use App\Models\Board\Space;
use App\Models\Pieces\Piece;
use App\Models\Pieces\Pieces;

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

    public function withVector(int $x, int $y): self
    {
        $newX = $this->originalSpace()->filePosition() + $x;
        $newY = $this->originalSpace()->rankPosition() + $y;

        if (! self::isAPosition($newX, $newY)) {
            $this->newSpace = null;
        } else {
            $this->newSpace = app(Board::class)->space(Board::ranks()[$newY], Board::files()[$newX]);
        }

        return $this;
    }

    public function isDirection(Direction $direction, ?int $magnitude = null): bool
    {
        if (! $this->isOnTheBoard()) {
            return false;
        }

        $vector = $this->vector();

        switch ($direction) {
            case Direction::Up:
                if (isset($magnitude)) {
                    return $vector[1] === $magnitude;
                }

                return $vector[1] > 0;
            case Direction::Down:
                if (isset($magnitude)) {
                    return -$vector[1] === $magnitude;
                }

                return $vector[1] < 0;
            case Direction::Left:
                if (isset($magnitude)) {
                    return $vector[0] === $magnitude;
                }

                return $vector[0] < 0;
            case Direction::Right:
                if (isset($magnitude)) {
                    return -$vector[0] === $magnitude;
                }

                return $vector[0] > 0;
            default:
                return false;
        }
    }

    public function capturesAPiece(): bool
    {
        if ($this->newSpace()->isOccupied() && $this->piece()->canCapture($this->newSpace()->piece())) {
            return true;
        }

        return false;
    }

    public function capturedPiece(): Piece
    {
        return $this->newSpace()->piece();
    }

    public function vector(): array
    {
        $originalY = $this->originalSpace()->rankPosition();
        $originalX = $this->originalSpace()->filePosition();
        $newY = $this->newSpace()->rankPosition();
        $newX = $this->newSpace()->filePosition();

        return [
            $newX - $originalX,
            $newY - $originalY,
        ];
    }

    public function path(): array
    {
        $vector = $this->vector();
        $positionX = $vector[0];
        $positionY = $vector[1];

        // Are we moving along an axis towards the positive, negative, or not at all along the axis
        $modifierX = $positionX <=> 0;
        $modifierY = $positionY <=> 0;
        // How far do we need to travel to get to the new space
        $distance = max(abs($positionX), abs($positionY));

        $path = [];
        $magnitude = 1;
        while ($magnitude < $distance) {

            $newX = $this->originalSpace()->filePosition() + ($modifierX * $magnitude);
            $newY = $this->originalSpace()->rankPosition() + ($modifierY * $magnitude);

            $path[] = app(Board::class)->space(Board::ranks()[$newY], Board::files()[$newX]);

            $magnitude++;
        }

        return $path;
    }

    public function isObstructed(): bool
    {
        if (! $this->piece()->requiresAClearPath()) {
            return false;
        }

        return array_reduce(
            $this->path(),
            fn (bool $carry, Space $space) => $carry || $space->isOccupied(),
            false);
    }

    public function isCastling(): bool
    {
        return $this->piece()->name === Pieces::King
            && abs($this->vector()[0]) > 1;
    }

    private static function isAPosition(int $newX, int $newY): bool
    {
        return $newX >= 0 && $newX < 8
            && $newY >= 0 && $newY < 8;
    }
}
