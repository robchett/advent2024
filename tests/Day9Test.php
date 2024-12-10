<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Robchett\Aoc2024\Task;

final class Day9Test extends TestCase
{
    public function testPart1(): void
    {
        $input = "2333133121414131402";
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day9.php';
        $res = $runner->task1();
        $this->assertSame(1928, $res->unwrap());
    }

    public function testPart2(): void
    {
        $input = "2333133121414131402";
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day9.php';
        $res = $runner->task2();
        $this->assertSame(2858, $res->unwrap());
    }
}