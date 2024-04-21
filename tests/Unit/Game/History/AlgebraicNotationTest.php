<?php

namespace Tests\Unit\Game\History;

use App\Models\Game\History\AlgebraicNotation;
use PHPUnit\Framework\TestCase;

class AlgebraicNotationTest extends TestCase
{
    public function testIsValidReturnsFalse(): void
    {
        $this->assertFalse(AlgebraicNotation::isValid('LMAO'));
    }

    public function testIsValidReturnsTrue(): void
    {
        $this->assertTrue(AlgebraicNotation::isValid('Qd5'));
    }

    public function testIsValidReturnsFalse(): void
    {
        $this->assertFalse(AlgebraicNotation::isValid('LMAO'));
    }

    public function testKasparovVsTopalovIsValid(): void
    {
        $game = [
            'e4', 'd6', 'd4', 'Nf6', 'Nc3', 'g6', 'Be3', 'Bg7', 'Qd2', 'c6', 'f3', 'b5', 'Nge2', 'Nbd7', 'Bh6', 'Bxh6',
            'Qxh6', 'Bb7', 'a3', 'e5', 'O-O-O', 'Qe7', 'Kb1', 'a6', 'Nc1', 'O-O-O', 'Nb3', 'exd4', 'Rxd4', 'c5', 'Rd1',
            'Nb6', 'g3', 'Kb8', 'Na5', 'Ba8', 'Bh3', 'd5', 'Qf4+', 'Ka7', 'Rhe1', 'd4', 'Nd5', 'Nbxd5', 'exd5', 'Qd6',
            'Rxd4', 'cxd4', 'Re7+', 'Kb6', 'Qxd4+', 'Kxa5', 'b4+', 'Ka4', 'Qc3', 'Qxd5', 'Ra7', 'Bb7', 'Rxb7', 'Qc4',
            'Qxf6', 'Kxa3', 'Qxa6+', 'Kxb4', 'c3+', 'Kxc3', 'Qa1+', 'Kd2', 'Qb2+', 'Kd1', 'Bf1', 'Rd2', 'Rd7', 'Rxd7',
            'Bxc4', 'bxc4', 'Qxh8', 'Rd3', 'Qa8', 'c3', 'Qa4+', 'Ke1', 'f4', 'f5', 'Kc1', 'Rd2', 'Qa7',
        ];
        
        foreach ($game as $move) {
            $this->assertTrue(AlgebraicNotation::isValid($move), 'Move is not valid: '.$move);
        }
    }

    public function testBeliavskyVsNunnIsValid(): void
    {
        $game = [
            'd4', 'Nf6', 'c4', 'g6', 'Nc3', 'Bg7', 'e4', 'd6', 'f3', 'O-O', 'Be3', 'Nbd7', 'Qd2', 'c5', 'd5', 'Ne5',
            'h3', 'Nh5', 'Bf2', 'f5', 'exf5', 'Rxf5', 'g4', 'Rxf3', 'gxh5', 'Qf8', 'Ne4', 'Bh6', 'Qc2', 'Qf4', 'Ne2',
            'Rxf2', 'Nxf2', 'Nf3+', 'Kd1', 'Qh4', 'Nd3', 'Bf5', 'Nec1', 'Nd2', 'hxg6', 'hxg6', 'Bg2', 'Nxc4', 'Qf2',
            'Ne3+', 'Ke2', 'Qc4', 'Bf3', 'Rf8', 'Rg1', 'Nc2', 'Kd1', 'Bxd3', 
        ];
        
        foreach ($game as $move) {
            $this->assertTrue(AlgebraicNotation::isValid($move), 'Move is not valid: '.$move);
        }
    }
}
