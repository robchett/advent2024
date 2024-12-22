<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Robchett\Aoc2124\Task;

final class Day21Test extends TestCase
{
    public function testPart1(): void
    {
        $input = <<<input
        029A
        980A
        179A
        456A
        379A
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day21.php';
        $res = $runner->task1();
        $this->assertSame(126384, $res->unwrap());
    }

    public function testPart2(): void
    {
        $input = <<<input
        029A
        980A
        179A
        456A
        379A
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day21.php';
        $res = $runner->task2();
        $this->assertSame(285, $res->unwrap());
    }
}