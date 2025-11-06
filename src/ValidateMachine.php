<?php

namespace PrFsm;

use PrFsm\Exceptions\MachineInvalidStatesException;
use PrFsm\Exceptions\MachineInvalidAlphabetException;
use PrFsm\Exceptions\MachineInvalidInitialStateException;
use PrFsm\Exceptions\MachineInvalidOutputStatesException;
use PrFsm\Exceptions\MachineInvalidTransitionException;

class ValidateMachine
{
    /**
     * @param array $states
     * @param array $inputAlphabet
     * @param mixed $initialState
     * @param array $outputStates
     * @param \Closure $transitionFn
     * @return void
     * @throws MachineInvalidAlphabetException
     * @throws MachineInvalidInitialStateException
     * @throws MachineInvalidOutputStatesException
     * @throws MachineInvalidStatesException
     * @throws MachineInvalidTransitionException
     */
    public static function validateInitialInput(
        array $states,
        array $inputAlphabet,
        mixed $initialState,
        array $outputStates,
        \Closure $transitionFn,
    ): void
    {
        if (count($states) < 2) {
            throw new MachineInvalidStatesException('Provided initial state is invalid, provide at least two states.');
        }
        if (empty($inputAlphabet)) {
            throw new MachineInvalidAlphabetException('Provided input alphabet is invalid, provide at least one input.');
        }
        if (!in_array($initialState, $states, true)) {
            throw new MachineInvalidInitialStateException('Provided initial state is invalid, ensure initial state is contained in states.');
        }
        if (count($outputStates) !== count($states)) {
            throw new MachineInvalidOutputStatesException('Provided output states are invalid, ensure states and output states have the same length.');
        }
        self::validateTransitionFunction($transitionFn);
    }

    private static function validateTransitionFunction(\Closure $transitionFn): void
    {
        $r = new \ReflectionFunction($transitionFn);
        if ($r->getNumberOfParameters() !== 2) {
            throw new MachineInvalidTransitionException('Invalid transition function provided, function should accept two parameters: state and input');
        }
    }
}
