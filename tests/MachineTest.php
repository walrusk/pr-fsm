<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Fixtures\Mod3Machine;
use Tests\Fixtures\DalmationMachine;
use PrFsm\Exceptions\MachineInvalidInputException;
use PrFsm\Exceptions\MachineTransitionException;
use PrFsm\Exceptions\MachineInvalidResultException;
use PrFsm\Exceptions\MachineInvalidOutputException;
use PrFsm\Machine;

final class MachineTest extends TestCase
{
    #[DataProvider('mod3Cases')]
    public function testMod3Cases(string $input, int $expected): void
    {
        $mod3machine = Mod3Machine::make();
        $result = $mod3machine->process($input);
        $this->assertSame($expected, $result);
    }

    public static function mod3Cases(): array {
        return [
            // basic cases
            'basic case 1' => ['1101', 1],
            'basic case 2' => ['1110', 2],
            'basic case 3' => ['1111', 0],
            'basic case 4' => [decbin(30), 0],
            'basic case 5' => [decbin(31), 1],
            'large number' => [decbin(1000), 1],
            // edge cases
            'leading zeros' => ['001101', 1],
            'leading space' => ['  1101', 1],
            'trailing space' => ['  1111  ', 0],
        ];
    }

    public function testHandlesInvalidInput(): void
    {
        $mod3machine = Mod3Machine::make();
        $this->expectException(MachineInvalidInputException::class);
        $mod3machine->process('foo');
    }

    public function testHandlesTransitionFnException()
    {
        $mod3machine = Mod3Machine::makeWithTransitionFn(function (int $state, string $input) {
            throw new \Exception('Test Exception -- testHandlesTransitionFnException');
        });
        $this->expectException(MachineTransitionException::class);
        $mod3machine->process('1111');
    }

    public function testHandlesInvalidResult()
    {
        $mod3machine = Mod3Machine::makeWithTransitionFn(function (int $state, string $input) {
            return 4;
        });
        $this->expectException(MachineInvalidResultException::class);
        $mod3machine->process('1111');
    }

    public function testMachineResets()
    {
        $mod3machine = Mod3Machine::make();
        $output1 = $mod3machine->process(decbin(7));
        $mod3machine->reset();
        $output2 = $mod3machine->process(decbin(7));
        $mod3machine->reset();
        $output3 = $mod3machine->process(decbin(7));

        $this->assertSame($output1, $output2);
        $this->assertSame($output1, $output3);
    }

    public function testMachineProducesOutput()
    {
        $mod3machine = new Machine(
            [0, 1, 2],  // 0 allowed
            ["0", "1"],
            0,
            ['test', 'test', 'test'],     // 0 not allowed in output
            function (int $state, string $input) { return 0; }
        );
        $output = $mod3machine->process('1111');
        $this->assertSame('test', $output);
    }

    #[DataProvider('dalmationCases')]
    public function testDalmationCases(string $input, bool $expected): void
    {
        $machine = DalmationMachine::make();
        $result = $machine->process($input);
        $this->assertSame($expected, $result);
    }

    public static function dalmationCases(): array {
        // The dalmation machine determines if 101 appears in the binary number.
        return [
            'case 1' => ['1101', true],
            'case 2' => ['1110', false],
            'case 3' => ['1111', false],
            'case 4' => ['1000', false],
            'case 5' => ['11101111', true],
            'case 6' => ['1000001000001', false],
            'case 7' => ['100000100000100', false],
            'case 8' => ['1010101', true],
        ];
    }
}
