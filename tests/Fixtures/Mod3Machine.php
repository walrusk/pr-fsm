<?php

namespace Tests\Fixtures;

use PrFsm\Machine;

class Mod3Machine
{
    public static function make(): Machine
    {
        return new Machine(
            [Mod3State::S0, Mod3State::S1, Mod3State::S2],
            ["0", "1"],
            Mod3State::S0,
            [Mod3State::S0, Mod3State::S1, Mod3State::S2],
            function (int $state, string $input) {
                $bit = $input === '1' ? 1 : 0;

                $next = [
                    /* S0 */ [Mod3State::S0, Mod3State::S1],
                    /* S1 */ [Mod3State::S2, Mod3State::S0],
                    /* S2 */ [Mod3State::S1, Mod3State::S2],
                ];

                if (!isset($next[$state])) {
                    throw new \Exception('Invalid state: ' . $state);
                }

                return $next[$state][$bit];
            },
        );
    }
}

final class Mod3State
{
    public const int S0 = 0; // remainder 0
    public const int S1 = 1; // remainder 1
    public const int S2 = 2; // remainder 2
}
