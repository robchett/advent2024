<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Robchett\Aoc2024\Task;

final class Day13Test extends TestCase
{
    public function testPart1(): void
    {
        $input = <<<input
        Button A: X+94, Y+34
        Button B: X+22, Y+67
        Prize: X=8400, Y=5400
        
        Button A: X+26, Y+66
        Button B: X+67, Y+21
        Prize: X=12748, Y=12176
        
        Button A: X+17, Y+86
        Button B: X+84, Y+37
        Prize: X=7870, Y=6450
        
        Button A: X+69, Y+23
        Button B: X+27, Y+71
        Prize: X=18641, Y=10279
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day13.php';
        $res = $runner->task1();
        $this->assertSame(480, $res->unwrap());
    }

    public function testPart2(): void
    {
        $input = <<<input
        Button A: X+94, Y+34
        Button B: X+22, Y+67
        Prize: X=8400, Y=5400
        
        Button A: X+26, Y+66
        Button B: X+67, Y+21
        Prize: X=12748, Y=12176
        
        Button A: X+17, Y+86
        Button B: X+84, Y+37
        Prize: X=7870, Y=6450
        
        Button A: X+69, Y+23
        Button B: X+27, Y+71
        Prize: X=18641, Y=10279
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day13.php';
        $res = $runner->task2();
        $this->assertSame(875318608908, $res->unwrap());
    }
}