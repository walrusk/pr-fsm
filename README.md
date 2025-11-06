# PR FSM

A library for a finite state machine.

![CI](https://github.com/walrusk/pr-fsm/actions/workflows/ci.yml/badge.svg?branch=main)

## Tests

Run tests:

```sh
# Runs in docker container with code coverage output.
./tests/run.sh
```

**Maintain test coverage!**

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

### Instantiating a Machine

```php
use PrFsm\Machine;
$machine = new Machine($states, $inputAlphabet, $initialState, $outputStates, $transitionFn);
```

| Parameter        | Type       | Component | Description                                                         |
|------------------|------------|-----------|---------------------------------------------------------------------|
| `$states`        | `array`    | Q         | Finite set of states.                                               |
| `$inputAlphabet` | `array`    | Σ         | Finite input alphabet.                                              |
| `$initialState`  | `mixed`    | q0 ∈ Q    | The initial state. Must be one of $states                           |
| `$outputStates`  | `array`    | F ⊆ Q     | The set of accepting/final states as a parallel array to `$states`. |
| `$transitionFn`  | `\Closure` | δ:Q×Σ→Q   | Function defining transitions: `fn(state, input): state`.           |

### Mod 3 example

**NB: See below mod3 example and other basic examples in `/examples`**

```php
use PrFsm\Machine;

final class Mod3State
{
    public const int S0 = 0; // remainder 0
    public const int S1 = 1; // remainder 1
    public const int S2 = 2; // remainder 2
}

$mod3machine = new Machine(
    [Mod3State::S0, Mod3State::S1, Mod3State::S2],
    ["0", "1"],
    Mod3State::S0,
    [0, 1, 2],
    function (int $state, string $input) {
        $bit = $input === '1' ? 1 : 0;

        $next = [
            /* S0 */ [Mod3State::S0, Mod3State::S1],
            /* S1 */ [Mod3State::S2, Mod3State::S0],
            /* S2 */ [Mod3State::S1, Mod3State::S2],
        ];

        if (!isset($next[$state])) {
            throw new \Exception('Invalid state: ' . $state);
        }

        return $next[$state][$bit];
    },
);

$output = $mod3machine->process('1101');
```

## Dev setup

Install deps: `composer install`
