<?php

namespace App\Models\Game\History;

class AlgebraicNotation
{
    private $spaceRegex = '[a-h][1-8]';

    private $majorPieceRegex = '[RKBQK]';

    private $capturesRegex = 'x';

    private $checksRegex = '[\!\#]';

    private $promotesRegex = '=';

    private $castleRegex = '0(-0){1,2}';
}
