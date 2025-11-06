<?php

namespace PrFsm\Exceptions;

class MachineInvalidInitialStateException extends MachineException
{
    public function __construct($message = "Provided initial state is invalid.", $code = 0, ?\Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
