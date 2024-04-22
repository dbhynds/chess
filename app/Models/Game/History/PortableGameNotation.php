<?php

namespace App\Models\Game\History;

class PortableGameNotation
{
    public const rank = '[1-8]';

    public const file = '[a-h]';

    public const space = self::file.self::rank;

    public const majorPieces = '[RNBQK]';

    public const zeroOrOne = '{0,1}';

    public const piece = self::majorPieces.self::zeroOrOne;

    public const captures = 'x'.self::zeroOrOne;

    public const checks = '[+#]'.self::zeroOrOne;

    public const promotes = self::file.'[1,8]='.self::majorPieces;

    public const castle = 'O(-O){1,2}';

    public static function regex(): string
    {
        $disambiguation = [
            '(', self::file, '|', self::rank, '|', self::space, ')', self::zeroOrOne,
        ];
        $regularMove = [
            '(', self::piece, ...$disambiguation, ')',
            // Maybe captures
            self::captures,
            // Targe
            self::space,
        ];
        $moveTypes = [
            // Castling
            '(',  self::castle, ')',
            // Or pawn promotion
            '|', '(', self::promotes, ')',
            // Or regular move
            '|',  '(', ...$regularMove, ')',
        ];

        return implode([
            '/^',
            '(', ...$moveTypes, ')',
            self::checks,
            '$/',
        ]);
    }

    public static function isValid(string $notation): bool
    {
        return preg_match(self::regex(), $notation) > 0;
    }
}
