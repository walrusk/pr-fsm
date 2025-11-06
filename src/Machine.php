<?php

namespace PrFsm;

use PrFsm\Exceptions\MachineTransitionException;
use PrFsm\Exceptions\MachineInvalidInputException;
use PrFsm\Exceptions\MachineInvalidResultException;

class Machine
{
    private mixed $currentState;

    /**
     * @param array $states
     * @param array $inputAlphabet
     * @param mixed $initialState
     * @param array $outputStates
     * @param \Closure $transitionFn
     * @throws Exceptions\MachineInvalidAlphabetException
     * @throws Exceptions\MachineInvalidInitialStateException
     * @throws Exceptions\MachineInvalidOutputStatesException
     * @throws Exceptions\MachineInvalidStatesException
     * @throws Exceptions\MachineInvalidTransitionException
     */
    public function __construct(
        private readonly array $states,
        private readonly array $inputAlphabet,
        private readonly mixed $initialState,
        private readonly array $outputStates,
        private readonly \Closure $transitionFn,
    )
    {
        ValidateMachine::validateInitialInput($states, $inputAlphabet, $initialState, $outputStates, $transitionFn);
        $this->currentState = $this->initialState;
    }

    /**
     * Steps through a string or array of input.
     * @param string|array $multiInput
     * @return mixed
     * @throws MachineInvalidInputException
     * @throws MachineInvalidResultException
     * @throws MachineTransitionException
     */
    public function process(string|array $multiInput): mixed
    {
        $multiInputArr = is_string($multiInput) ? mb_str_split(trim($multiInput)) : $multiInput;

        foreach ($multiInputArr as $input) {
            $this->step($input);
        }

        return $this->output();
    }

    /**
     * Transitions the machine to the next state.
     * @param mixed $input
     * @return mixed
     * @throws MachineInvalidInputException
     * @throws MachineInvalidResultException
     * @throws MachineTransitionException
     */
    public function step(mixed $input): mixed
    {
        if (!in_array($input, $this->inputAlphabet, true)) {
            throw new MachineInvalidInputException();
        }

        try {
            $nextState = ($this->transitionFn)($this->currentState, $input);
        } catch (\Throwable $e) {
            throw new MachineTransitionException("Transition exception.", 0, $e);
        }

        if (!in_array($nextState, $this->states, true)) {
            throw new MachineInvalidResultException();
        }

        $this->currentState = $nextState;

        return $nextState;
    }

    /**
     * @return mixed
     */
    public function output(): mixed
    {
        $currentStateIndex = array_search($this->currentState, $this->states, true);
        return $this->outputStates[$currentStateIndex];
    }

    /**
     * @return void
     */
    public function reset(): void
    {
        $this->currentState = $this->initialState;
    }
}
