<?php

namespace PrFsm\Exceptions;

class MachineTransitionException extends MachineException
{
    public function __construct($message = "Transition exception thrown.", $code = 0, ?\Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
