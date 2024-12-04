<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Robchett\Aoc2024\Task;

final class Day4Test extends TestCase
{
    public function testPart1(): void
    {
        $input = <<<input
        MMMSXXMASM
        MSAMXMSMSA
        AMXSXMAAMM
        MSAMASMSMX
        XMASAMXAMM
        XXAMMXXAMA
        SMSMSASXSS
        SAXAMASAAA
        MAMMMXMMMM
        MXMXAXMASX
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day4.php';
        $res = $runner->task1();
        $this->assertSame(18, $res->unwrap());
    }

    public function testPart2(): void
    {
        $input = <<<input
        MMMSXXMASM
        MSAMXMSMSA
        AMXSXMAAMM
        MSAMASMSMX
        XMASAMXAMM
        XXAMMXXAMA
        SMSMSASXSS
        SAXAMASAAA
        MAMMMXMMMM
        MXMXAXMASX
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day4.php';
        $res = $runner->task2();
        $this->assertSame(9, $res->unwrap());
    }
}