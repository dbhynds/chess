<?php

namespace App\Models\Board;

use Illuminate\Support\Collection;

class Board
{
    private Collection $spaces;

    public function __construct()
    {
        $spaces = [];
        foreach (self::ranks() as $rank) {
            foreach (self::files() as $file) {
                $space = new Space($file, $rank);
                $spaces[$space->name()] = $space;
            }
        }
        $this->spaces = collect($spaces);
    }

    public static function ranks(): array
    {
        return Rank::cases();
    }

    public static function files(): array
    {
        return File::cases();
    }

    /**
     * @return Collection<string, Space>
     */
    public function spaces(): Collection
    {
        return $this->spaces;
    }

    public function space(Rank $rank, File $file): ?Space
    {
        return $this->spaces()[Space::named($rank, $file)] ?? null;
    }
}
