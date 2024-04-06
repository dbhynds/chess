<?php

namespace App\Models\Board;

use Illuminate\Support\Collection;

class Board
{
    private Collection $spaces;

    public function __construct()
    {
        $spaces = [];
        foreach (Row::cases() as $row) {
            foreach (Column::cases() as $column) {
                $space = new Space($row, $column);
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

    public function space(Row $row, Column $column): Space
    {
        return $this->spaces()[Space::named($row, $column)];
    }
}
