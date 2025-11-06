<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use PrFsm\Machine;
use PrFsm\Exceptions\MachineInvalidStatesException;
use PrFsm\Exceptions\MachineInvalidAlphabetException;
use PrFsm\Exceptions\MachineInvalidInitialStateException;
use PrFsm\Exceptions\MachineInvalidOutputStatesException;
use PrFsm\Exceptions\MachineInvalidTransitionException;

final class ValidateMachineTest extends TestCase
{
    public function testValidatesMinimumTwoStates(): void
    {
        $this->expectException(MachineInvalidStatesException::class);
        new Machine(
            [0], // Only one state, at least two required.
            ["0", "1"],
            0,
            [0],
            function (int $state, string $input) {
                return $state;
            },
        );
    }

    public function testValidatesNonEmptyAlphabet()
    {
        $this->expectException(MachineInvalidAlphabetException::class);
        new Machine(
            [0, 1, 2],
            [], // Empty alphabet.
            0,
            [0, 1, 2],
            function (int $state, string $input) {
                return $state;
            },
        );
    }

    public function testValidatesInitialState()
    {
        $this->expectException(MachineInvalidInitialStateException::class);
        new Machine(
            [0, 1, 2],
            ["0", "1"],
            3, // Invalid initial state.
            [0, 1, 2],
            function (int $state, string $input) {
                return $state;
            },
        );
    }

    public function testValidatesNumOutputStates()
    {
        $this->expectException(MachineInvalidOutputStatesException::class);
        new Machine(
            [0, 1, 2],
            ["0", "1"],
            0,
            [0], // Only one output state, require the same number as states.
            function (int $state, string $input) {
                return $state;
            },
        );
    }

    public function testValidatesTransitionFn()
    {
        $this->expectException(MachineInvalidTransitionException::class);
        new Machine(
            [0, 1, 2],
            ["0", "1"],
            0,
            [0, 1, 2],
            function (int $state) { // Transition fn has arity of 1, should be 2.
                return $state;
            },
        );
    }
}
