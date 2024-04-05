<?php

namespace App\Models\Board;

use Illuminate\Support\Collection;

class Board
{
    private Collection $spaces;

    public function __construct()
    {
        $spaces = [];
        foreach (Row::NAMES as $rowName) {
            foreach (Column::NAMES as $columnName) {
                $space = new Space($rowName, $columnName);
                $spaces[$space->name()] = $space;
            }
        }
        $this->spaces = collect($spaces);
    }

    /**
     * @return Collection<string, Space>
     */
    public function spaces(): Collection
    {
        return $this->spaces;
    }
}
