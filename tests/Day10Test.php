<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Robchett\Aoc2024\Task;

final class Day10Test extends TestCase
{
    public function testPart1(): void
    {
        $input = <<<input
        89010123
        78121874
        87430965
        96549874
        45678903
        32019012
        01329801
        10456732
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day10.php';
        $res = $runner->task1();
        $this->assertSame(36, $res->unwrap());
    }

    public function testPart2(): void
    {
        $input = <<<input
        89010123
        78121874
        87430965
        96549874
        45678903
        32019012
        01329801
        10456732
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day10.php';
        $res = $runner->task2();
        $this->assertSame(81, $res->unwrap());
    }
}