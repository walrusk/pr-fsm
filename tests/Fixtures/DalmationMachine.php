<?php

namespace Tests\Fixtures;

use PrFsm\Machine;

/**
 * Machine to determine if 101 appears in a binary number.
 */
class DalmationMachine
{
    public static function make(): Machine
    {
        return new Machine(
            [DalmationState::S0, DalmationState::S1, DalmationState::S2, DalmationState::S3],
            ["0", "1"],
            DalmationState::S0,
            [false, false, false, true],
            function (int $state, string $input) {
                if ($state === DalmationState::S3) { // Found 101 already.
                    return $state;
                }

                $numberSoFar = [
                    '',   // S0
                    '1',  // S1
                    '10', // S2
                ];

                return match ($numberSoFar[$state] . $input) {
                    '1', '11' => DalmationState::S1,
                    '10' => DalmationState::S2,
                    '101' => DalmationState::S3,
                    default => DalmationState::S0,
                };
            },
        );
    }
}

final class DalmationState
{
    public const int S0 = 0; // Nothing found.
    public const int S1 = 1; // Last symbol was 1.
    public const int S2 = 2; // Last two symbols were 10.
    public const int S3 = 3; // 101 found!
}
