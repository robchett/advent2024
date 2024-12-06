<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Robchett\Aoc2024\Task;

final class Day6Test extends TestCase
{
    public function testPart1(): void
    {
        $input = <<<input
        ....#.....
        .........#
        ..........
        ..#.......
        .......#..
        ..........
        .#..^.....
        ........#.
        #.........
        ......#...
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day6.php';
        $res = $runner->task1();
        $this->assertSame(41, $res->unwrap());
    }

    public function testPart2(): void
    {
        $input = <<<input
        ....#.....
        .........#
        ..........
        ..#.......
        .......#..
        ..........
        .#..^.....
        ........#.
        #.........
        ......#...
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day6.php';
        $res = $runner->task2();
        $this->assertSame(6, $res->unwrap());
    }
}