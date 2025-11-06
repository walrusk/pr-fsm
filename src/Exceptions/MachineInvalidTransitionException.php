<?php


namespace PrFsm\Exceptions;

class MachineInvalidTransitionException extends MachineException
{
    public function __construct($message = "Invalid transition function provided.", $code = 0, ?\Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
