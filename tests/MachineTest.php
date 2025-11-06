<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Fixtures\Mod3Machine;

final class MachineTest extends TestCase
{
    #[DataProvider('mod3cases')]
    public function testMod3Cases(string $input, int $expected): void
    {
        $mod3machine = Mod3Machine::make();
        $result = $mod3machine->process($input);
        $this->assertSame($expected, $result);
    }

    public static function mod3cases(): array {
        return [
            'mod3 case 1' => ['1101', 1],
            'mod3 case 2' => ['1110', 2],
            'mod3 case 3' => ['1111', 0],
        ];
    }
}
