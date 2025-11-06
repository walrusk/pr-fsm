# PR FSM

A library for a finite state machine.

## Tests

Run tests:

```sh
# Runs in docker container with code coverage output.
./tests/run.sh
```

NB: Maintain test coverage!

```
Code Coverage Report Summary:
  Classes: 100.00% (10/10)
  Methods: 100.00% (15/15)
  Lines:   100.00% (38/38)
```

## Installation

### 1. Add repo to composer.json:

```json
{
    "repositories": [
      {
        "type": "vcs",
        "url": "https://github.com/walrusk/pr-fsm"
      }
    ]
}
```

### 2. Require the package

```sh
composer require walrusk/pr-fsm
```

## Usage

NB: See basic examples in `/examples`

### Basic light switch example

```php
use PrFsm\Machine;

final class LightSwitch
{
    public const bool ON = true;
    public const bool OFF = false;
}

$lightswitch = new Machine(
    [LightSwitch::OFF, LightSwitch::ON],    // Allowed states.
    [null],                                 // Input alphabet.
    LightSwitch::OFF,                       // Initial state.
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
```

## Dev setup

Install deps: `composer install`
