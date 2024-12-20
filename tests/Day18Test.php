<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Robchett\Aoc2024\Task;

final class Day18Test extends TestCase
{
    public function testPart1(): void
    {
        $input = <<<input
        5,4
        4,2
        4,5
        3,0
        2,1
        6,3
        2,4
        1,5
        0,6
        3,3
        2,6
        5,1
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day18.php';
        $res = $runner->task1();
        $this->assertSame(22, $res->unwrap());
    }

    public function testPart2(): void
    {
        $input = <<<input
        5,4
        4,2
        4,5
        3,0
        2,1
        6,3
        2,4
        1,5
        0,6
        3,3
        2,6
        5,1
        1,2
        5,5
        2,5
        6,5
        1,4
        0,4
        6,4
        1,1
        6,1
        1,0
        0,5
        1,6
        2,0
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day18.php';
        $res = $runner->task2();
        $this->assertSame('6,1', $res->unwrap());
    }
}