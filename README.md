# PR FSM

A library for a finite state machine.

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

NB: See examples in `/examples`

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
    [LightSwitch::OFF, LightSwitch::ON],    // Allowed output states.
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

## Tests

Install deps: `composer install`

Run tests: `./tests/run.sh`
