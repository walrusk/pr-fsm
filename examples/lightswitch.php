<?php

require __DIR__ . '/../vendor/autoload.php';

use PrFsm\Machine;

final class LightSwitch
{
    public const bool ON = true;
    public const bool OFF = false;
}

$lightswitch = new Machine(
    [LightSwitch::OFF, LightSwitch::ON],    // Allowed states.
    [null],                                 // Input alphabet.
    LightSwitch::OFF,             // Initial state.
    ['OFF', 'ON'],                          // Output by state.
    function (bool $state, mixed $input) {  // Transition function.
        return !$state;
    },
);

// flick the switch
$lightswitch->step(null);
$output = $lightswitch->output();

// flick the switch 3 times
$output = $lightswitch->process([null, null, null]);

echo "Lightswitch is: $output";
