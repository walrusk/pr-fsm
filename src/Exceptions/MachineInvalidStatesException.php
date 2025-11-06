<?php

namespace PrFsm\Exceptions;

class MachineInvalidStatesException extends MachineException
{
    public function __construct($message = "Provided states are invalid.", $code = 0, ?\Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
