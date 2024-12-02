<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Robchett\Aoc2024\Task;

final class Day2Test extends TestCase
{
    public function testPart1(): void
    {
        $input = <<<input
        7 6 4 2 1
        1 2 7 8 9
        9 7 6 2 1
        1 3 2 4 5
        8 6 4 4 1
        1 3 6 7 9
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day2.php';
        $res = $runner->task1();
        $this->assertSame(2, $res->unwrap());
    }

    public function testPart2(): void
    {
        $input = <<<input
        7 6 4 2 1
        1 2 7 8 9
        9 7 6 2 1
        1 3 2 4 5
        8 6 4 4 1
        1 3 6 7 9
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day2.php';
        $res = $runner->task2();
        $this->assertSame(4, $res->unwrap());
    }
}