<?php

namespace PrFsm\Exceptions;

class MachineInvalidOutputException extends MachineException
{
    public function __construct($message = "Current state is not valid for output.", $code = 0, ?\Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
