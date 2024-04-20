<?php

namespace App\Models\Game\History;

class AlgebraicNotation
{
    public const rank = '[1-8]';

    public const file = '[a-h]';

    public const space = self::file.self::rank;

    public const piece = '[RKBQK]{0,1}';

    public const captures = 'x{0,1}';

    public const checks = '[\!\#]';

    public const promotes = '=';

    public const castle = 'O(-O){1,2}';

    public const regex = '^'.self::piece.self::captures.self::space.'$';

    public static function isValid(string $notation): bool
    {
        return preg_match(self::regex, $notation) > 0;
    }
}
