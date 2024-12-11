<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Robchett\Aoc2024\Task;

final class Day11Test extends TestCase
{
    public function testPart1(): void
    {
        $input = "125 17";
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day11.php';
        $res = $runner->task1();
        $this->assertSame(55312, $res->unwrap());
    }

    public function testPart2(): void
    {
        $input = "125 17";
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day11.php';
        $res = $runner->task2();
        $this->assertSame(65601038650482, $res->unwrap());
    }
}