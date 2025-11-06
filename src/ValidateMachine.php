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
        if (count($outputStates) < 2 || !self::isSubset($outputStates, $states)) {
            throw new MachineInvalidOutputStatesException('Provided output states are invalid, provide at least two that are a subset of the provided states.');
        }
        self::validateTransitionFunction($transitionFn);
    }

    private static function isSubset(array $subset, array $set): bool {
        foreach ($subset as $value) {
            if (!in_array($value, $set, true)) return false;
        }
        return true;
    }

    private static function validateTransitionFunction(\Closure $transitionFn): void
    {
        $r = new \ReflectionFunction($transitionFn);
        if ($r->getNumberOfParameters() !== 2) {
            throw new MachineInvalidTransitionException('Invalid transition function provided, function should accept two parameters: state and input');
        }
    }
}
