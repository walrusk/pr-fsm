<?php

namespace PrFsm\Exceptions;

class MachineInvalidAlphabetException extends MachineException
{
    public function __construct($message = "Provided input alphabet is invalid.", $code = 0, ?\Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
