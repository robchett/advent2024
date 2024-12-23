<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Robchett\Aoc2024\Task;

final class Day1Test extends TestCase
{
    public function testPart1(): void
    {
        $input = <<<input
        3   4
        4   3
        2   5
        1   3
        3   9
        3   3
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day1.php';
        $res = $runner->task1();
        $this->assertSame(11, $res->unwrap());
    }

    public function testPart2(): void
    {
        $input = <<<input
        3   4
        4   3
        2   5
        1   3
        3   9
        3   3
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day1.php';
        $res = $runner->task2();
        $this->assertSame(31, $res->unwrap());
    }
}