<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Robchett\Aoc2024\Task;

final class Day20Test extends TestCase
{
    public function testPart1(): void
    {
        $input = <<<input
        ###############
        #...#...#.....#
        #.#.#.#.#.###.#
        #S#...#.#.#...#
        #######.#.#.###
        #######.#.#...#
        #######.#.###.#
        ###..E#...#...#
        ###.#######.###
        #...###...#...#
        #.#####.#.###.#
        #.#...#.#.#...#
        #.#.#.#.#.#.###
        #...#...#...###
        ###############
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day20.php';
        $res = $runner->task1();
        $this->assertSame(44, $res->unwrap());
    }

    public function testPart2(): void
    {
        $input = <<<input
        ###############
        #...#...#.....#
        #.#.#.#.#.###.#
        #S#...#.#.#...#
        #######.#.#.###
        #######.#.#...#
        #######.#.###.#
        ###..E#...#...#
        ###.#######.###
        #...###...#...#
        #.#####.#.###.#
        #.#...#.#.#...#
        #.#.#.#.#.#.###
        #...#...#...###
        ###############
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day20.php';
        $res = $runner->task2();
        $this->assertSame(285, $res->unwrap());
    }
}