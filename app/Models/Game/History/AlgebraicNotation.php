<?php

namespace App\Models\Game\History;

class AlgebraicNotation
{

    public const rank = '[1-8]';

    public const file = '[a-h]';

    public const space = self::file.self::rank;

    public const pawn = self::space;

    public const majorPieces = '[RNBQK]';

    public const zeroOrOne = '{0,1}';

    public const piece = self::majorPieces.self::zeroOrOne;

    public const captures = 'x'.self::zeroOrOne;

    public const checks = '[+#]'.self::zeroOrOne;

    public const promotes = self::pawn.'='.self::majorPieces;

    public const castle = 'O(-O){1,2}';

    public static function regex(): string
    {
        return implode([
            '/^',
                '(',
                    '(',
                        // Castling
                        self::castle,
                    ')', '|', '(',
                        // Pawn promotion
                        self::promotes,
                    ')', '|', '(',
                        '(',
                            self::piece,
                            // Disambiguating 
                            '(', self::file, '|', self::rank, '|', self::space, ')', self::zeroOrOne,
                        ')',
                        self::captures,
                        self::space,
                    ')',
                ')',
                self::checks,
            '$/'
        ]);
    }

    public static function isValid(string $notation): bool
    {
        return preg_match(self::regex(), $notation) > 0;
    }
}
