<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Robchett\Aoc2024\Task;

final class Day5Test extends TestCase
{
    public function testPart1(): void
    {
        $input = <<<input
        47|53
        97|13
        97|61
        97|47
        75|29
        61|13
        75|53
        29|13
        97|29
        53|29
        61|53
        97|53
        61|29
        47|13
        75|47
        97|75
        47|61
        75|61
        47|29
        75|13
        53|13
        
        75,47,61,53,29
        97,61,53,29,13
        75,29,13
        75,97,47,61,53
        61,13,29
        97,13,75,29,47
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day5.php';
        $res = $runner->task1();
        $this->assertSame(143, $res->unwrap());
    }

    public function testPart2(): void
    {
        $input = <<<input
        47|53
        97|13
        97|61
        97|47
        75|29
        61|13
        75|53
        29|13
        97|29
        53|29
        61|53
        97|53
        61|29
        47|13
        75|47
        97|75
        47|61
        75|61
        47|29
        75|13
        53|13
        
        75,47,61,53,29
        97,61,53,29,13
        75,29,13
        75,97,47,61,53
        61,13,29
        97,13,75,29,47
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day5.php';
        $res = $runner->task2();
        $this->assertSame(123, $res->unwrap());
    }
}