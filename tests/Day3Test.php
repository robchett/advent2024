<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Robchett\Aoc2024\Task;

final class Day3Test extends TestCase
{
    public function testPart1(): void
    {
        $input = "xmul(2,4)%&mul[3,7]!@^do_not_mul(5,5)+mul(32,64]then(mul(11,8)mul(8,5))";
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day3.php';
        $res = $runner->task1();
        $this->assertSame(161, $res->unwrap());
    }

    public function testPart2(): void
    {
        $input = "xmul(2,4)&mul[3,7]!^don't()_mul(5,5)+mul(32,64](mul(11,8)undo()?mul(8,5))";
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day3.php';
        $res = $runner->task2();
        $this->assertSame(48, $res->unwrap());
    }
}