<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Robchett\Aoc2024\Task;

final class Day7Test extends TestCase
{
    public function testPart1(): void
    {
        $input = <<<input
        190: 10 19
        3267: 81 40 27
        83: 17 5
        156: 15 6
        7290: 6 8 6 15
        161011: 16 10 13
        192: 17 8 14
        21037: 9 7 18 13
        292: 11 6 16 20
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day7.php';
        $res = $runner->task1();
        $this->assertSame(3749, $res->unwrap());
    }

    public function testPart2(): void
    {
        $input = <<<input
        190: 10 19
        3267: 81 40 27
        83: 17 5
        156: 15 6
        7290: 6 8 6 15
        161011: 16 10 13
        192: 17 8 14
        21037: 9 7 18 13
        292: 11 6 16 20
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day7.php';
        $res = $runner->task2();
        $this->assertSame(11387, $res->unwrap());
    }
}