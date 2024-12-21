<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Robchett\Aoc2024\Task;

final class Day19Test extends TestCase
{
    public function testPart1(): void
    {
        $input = <<<input
        r, wr, b, g, bwu, rb, gb, br
        
        brwrr
        bggr
        gbbr
        rrbgbr
        ubwu
        bwurrg
        brgr
        bbrgwb
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day19.php';
        $res = $runner->task1();
        $this->assertSame(6, $res->unwrap());
    }

    public function testPart2(): void
    {
        $input = <<<input
        r, wr, b, g, bwu, rb, gb, br
        
        brwrr
        bggr
        gbbr
        rrbgbr
        ubwu
        bwurrg
        brgr
        bbrgwb
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day19.php';
        $res = $runner->task2();
        $this->assertSame(16, $res->unwrap());
    }
}