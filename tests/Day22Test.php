<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Robchett\Aoc2224\Task;

final class Day22Test extends TestCase
{
    public function testPart1(): void
    {
        $input = <<<input
        1
        10
        100
        2024
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day22.php';
        $res = $runner->task1();
        $this->assertSame(37327623, $res->unwrap());
    }

    public function testPart2(): void
    {
        $input = <<<input
        1
        2
        3
        2024
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day22.php';
        $res = $runner->task2();
        $this->assertSame(23, $res->unwrap());
    }
}