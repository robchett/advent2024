<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Robchett\Aoc2024\Task;

final class Day12Test extends TestCase
{
    public function testPart1(): void
    {
        $input = <<<input
        RRRRIICCFF
        RRRRIICCCF
        VVRRRCCFFF
        VVRCCCJFFF
        VVVVCJJCFE
        VVIVCCJJEE
        VVIIICJJEE
        MIIIIIJJEE
        MIIISIJEEE
        MMMISSJEEE
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day12.php';
        $res = $runner->task1();
        $this->assertSame(1930, $res->unwrap());
    }

    public function testPart2(): void
    {
        $input = <<<input
        RRRRIICCFF
        RRRRIICCCF
        VVRRRCCFFF
        VVRCCCJFFF
        VVVVCJJCFE
        VVIVCCJJEE
        VVIIICJJEE
        MIIIIIJJEE
        MIIISIJEEE
        MMMISSJEEE
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day12.php';
        $res = $runner->task2();
        $this->assertSame(1206, $res->unwrap());
    }
}