<?php

namespace App\Models\Pieces;

enum Pieces: string
{
    case Pawn = '';
    case Rook = 'R';
    case Knight = 'N';
    case Bishop = 'B';
    case Queen = 'Q';
    case King = 'K';
}
