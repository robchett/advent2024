<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Robchett\Aoc2024\Task;

final class Day17Test extends TestCase
{
    public function testPart1(): void
    {
        $input = <<<input
        Register A: 729
        Register B: 0
        Register C: 0
        
        Program: 0,1,5,4,3,0
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day17.php';
        $res = $runner->task1();
        $this->assertSame('4,6,3,5,6,3,5,2,1,0', $res->unwrap());
    }

    public function testPart2(): void
    {
        $input = <<<input
        Register A: 2024
        Register B: 0
        Register C: 0
        
        Program: 0,3,5,4,3,0
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day17.php';
        $res = $runner->task2();
        $this->assertSame(117440, $res->unwrap());
    }
}