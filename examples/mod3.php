<?php

require __DIR__ . '/../vendor/autoload.php';

use PrFsm\Machine;

final class Mod3State
{
    public const int S0 = 0; // remainder 0
    public const int S1 = 1; // remainder 1
    public const int S2 = 2; // remainder 2
}

/*
Q = (S0, S1, S2)
Σ = (0, 1)
q0 = S0
F = (S0, S1, S2)
δ(S0,0) = S0; δ(S0,1) = S1; δ(S1,0) = S2; δ(S1,1) = S0; δ(S2,0) = S1; δ(S2,1) = S2
 */

$mod3machine = new Machine(
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

$output = $mod3machine->process('1101');

echo 'Mod3 output: ' . $output;
