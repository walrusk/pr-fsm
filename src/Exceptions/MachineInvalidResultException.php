<?php

namespace PrFsm\Exceptions;

class MachineInvalidResultException extends MachineException
{
    public function __construct($message = "Result produced by transition is invalid.", $code = 0, ?\Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
