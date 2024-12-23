<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Robchett\Aoc2324\Task;

final class Day23Test extends TestCase
{
    public function testPart1(): void
    {
        $input = <<<input
        kh-tc
        qp-kh
        de-cg
        ka-co
        yn-aq
        qp-ub
        cg-tb
        vc-aq
        tb-ka
        wh-tc
        yn-cg
        kh-ub
        ta-co
        de-co
        tc-td
        tb-wq
        wh-td
        ta-ka
        td-qp
        aq-cg
        wq-ub
        ub-vc
        de-ta
        wq-aq
        wq-vc
        wh-yn
        ka-de
        kh-ta
        co-tc
        wh-qp
        tb-vc
        td-yn
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day23.php';
        $res = $runner->task1();
        $this->assertSame(7, $res->unwrap());
    }

    public function testPart2(): void
    {
        $input = <<<input
        kh-tc
        qp-kh
        de-cg
        ka-co
        yn-aq
        qp-ub
        cg-tb
        vc-aq
        tb-ka
        wh-tc
        yn-cg
        kh-ub
        ta-co
        de-co
        tc-td
        tb-wq
        wh-td
        ta-ka
        td-qp
        aq-cg
        wq-ub
        ub-vc
        de-ta
        wq-aq
        wq-vc
        wh-yn
        ka-de
        kh-ta
        co-tc
        wh-qp
        tb-vc
        td-yn
        input;
        /** @var Task $runner */
        $runner = require __DIR__ . '/../src/day23.php';
        $res = $runner->task2();
        $this->assertSame('co,de,ka,ta', $res->unwrap());
    }
}