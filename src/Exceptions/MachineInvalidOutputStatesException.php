<?php

namespace PrFsm\Exceptions;

class MachineInvalidOutputStatesException extends MachineException
{
    public function __construct($message = "Provided output states are invalid.", $code = 0, ?\Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
