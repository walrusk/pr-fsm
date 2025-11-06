<?php

namespace PrFsm\Exceptions;

class MachineInvalidInputException extends MachineException
{
    public function __construct($message = "Provided input is invalid.", $code = 0, ?\Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
