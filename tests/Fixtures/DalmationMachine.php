<?php

namespace Tests\Fixtures;

use PrFsm\Machine;

/**
 * Machine determines if 101 appears in a binary number.
 */
class DalmationMachine
{
    public static function make(): Machine
    {
        return new Machine(
            [DalmationState::S0, DalmationState::S1, DalmationState::S10, DalmationState::S101],
            ["0", "1"],
            DalmationState::S0,
            [false, false, false, true],
            function (int $state, string $input) {
                $bit = $input === '1' ? 1 : 0;

                switch ($state) {
                    case DalmationState::S0:
                        return $bit ? DalmationState::S1 : DalmationState::S0;
                    case DalmationState::S1:
                        return $bit ? DalmationState::S1 : DalmationState::S10;
                    case DalmationState::S10:
                        return $bit ? DalmationState::S101 : DalmationState::S0;
                    case DalmationState::S101:
                        return DalmationState::S101;
                }

                throw new \Exception('Invalid state: ' . $state);
            },
        );
    }
}

final class DalmationState
{
    public const int S0 = 0; // Nothing found.
    public const int S1 = 1; // Last symbol was 1.
    public const int S10 = 10; // Last two symbols were 10.
    public const int S101 = 101; // 101 found!
}
