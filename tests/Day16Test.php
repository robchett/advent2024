<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Robchett\Aoc2024\Task;

final class Day16Test extends TestCase
{
    public function testPart1(): void
    {
        $input = <<<input
        ###############
        #.......#....E#
        #.#.###.#.###.#
        #.....#.#...#.#
        #.###.#####.#.#
        #.#.#.......#.#
        #.#.#####.###.#
        #...........#.#
        ###.#.#####.#.#
        #...#.....#.#.#
        #.#.#.###.#.#.#
        #.....#...#.#.#
        #.###.#.#.#.#.#
        #S..#.....#...#
        ###############
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day16.php';
        $res = $runner->task1();
        $this->assertSame(7036, $res->unwrap());
    }

    public function testPart2(): void
    {
        $input = <<<input
        ###############
        #.......#....E#
        #.#.###.#.###.#
        #.....#.#...#.#
        #.###.#####.#.#
        #.#.#.......#.#
        #.#.#####.###.#
        #...........#.#
        ###.#.#####.#.#
        #...#.....#.#.#
        #.#.#.###.#.#.#
        #.....#...#.#.#
        #.###.#.#.#.#.#
        #S..#.....#...#
        ###############
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day16.php';
        $res = $runner->task2();
        $this->assertSame(45, $res->unwrap());
    }
}