<?php

namespace Robchett\Aoc2024;

use Robchett\Aoc2024\Input\TableStr;

/**
 * --- Day 18: RAM Run ---
 * You and The Historians look a lot more pixelated than you remember. You're inside a computer at the North Pole!
 * 
 * Just as you're about to check out your surroundings, a program runs up to you. "This region of memory isn't safe! The User misunderstood what a pushdown automaton is and their algorithm is pushing whole bytes down on top of us! Run!"
 * 
 * The algorithm is fast - it's going to cause a byte to fall into your memory space once every nanosecond! Fortunately, you're faster, and by quickly scanning the algorithm, you create a list of which bytes will fall (your puzzle input) in the order they'll land in your memory space.
 * 
 * Your memory space is a two-dimensional grid with coordinates that range from 0 to 70 both horizontally and vertically. However, for the sake of example, suppose you're on a smaller grid with coordinates that range from 0 to 6 and the following list of incoming byte positions:
 * 
 * 5,4
 * 4,2
 * 4,5
 * 3,0
 * 2,1
 * 6,3
 * 2,4
 * 1,5
 * 0,6
 * 3,3
 * 2,6
 * 5,1
 * 1,2
 * 5,5
 * 2,5
 * 6,5
 * 1,4
 * 0,4
 * 6,4
 * 1,1
 * 6,1
 * 1,0
 * 0,5
 * 1,6
 * 2,0
 * Each byte position is given as an X,Y coordinate, where X is the distance from the left edge of your memory space and Y is the distance from the top edge of your memory space.
 * 
 * You and The Historians are currently in the top left corner of the memory space (at 0,0) and need to reach the exit in the bottom right corner (at 70,70 in your memory space, but at 6,6 in this example). You'll need to simulate the falling bytes to plan out where it will be safe to run; for now, simulate just the first few bytes falling into your memory space.
 * 
 * As bytes fall into your memory space, they make that coordinate corrupted. Corrupted memory coordinates cannot be entered by you or The Historians, so you'll need to plan your route carefully. You also cannot leave the boundaries of the memory space; your only hope is to reach the exit.
 * 
 * In the above example, if you were to draw the memory space after the first 12 bytes have fallen (using . for safe and # for corrupted), it would look like this:
 * 
 * ...#...
 * ..#..#.
 * ....#..
 * ...#..#
 * ..#..#.
 * .#..#..
 * #.#....
 * You can take steps up, down, left, or right. After just 12 bytes have corrupted locations in your memory space, the shortest path from the top left corner to the exit would take 22 steps. Here (marked with O) is one such path:
 * 
 * OO.#OOO
 * .O#OO#O
 * .OOO#OO
 * ...#OO#
 * ..#OO#.
 * .#.O#..
 * #.#OOOO
 * Simulate the first kilobyte (1024 bytes) falling onto your memory space. Afterward, what is the minimum number of steps needed to reach the exit?
 * 
 * --- Part Two ---
 * The Historians aren't as used to moving around in this pixelated universe as you are. You're afraid they're not going to be fast enough to make it to the exit before the path is completely blocked.
 * 
 * To determine how fast everyone needs to go, you need to determine the first byte that will cut off the path to the exit.
 * 
 * In the above example, after the byte at 1,1 falls, there is still a path to the exit:
 * 
 * O..#OOO
 * O##OO#O
 * O#OO#OO
 * OOO#OO#
 * ###OO##
 * .##O###
 * #.#OOOO
 * However, after adding the very next byte (at 6,1), there is no longer a path to the exit:
 * 
 * ...#...
 * .##..##
 * .#..#..
 * ...#..#
 * ###..##
 * .##.###
 * #.#....
 * So, in this example, the coordinates of the first byte that prevents the exit from being reachable are 6,1.
 * 
 * Simulate more of the bytes that are about to corrupt your memory space. What are the coordinates of the first byte that will prevent the exit from being reachable from your starting position? (Provide the answer as two integers separated by a comma with no other characters.)
 * @template-implements Task<int, list<string>>
 */
return new class($input) implements Task {

    #[\Override] function __construct(protected string $input)
    {
    }

    #[\Override] public function task1(): TaskOutput
    {
        $coords = [];
        $xs = [];
        $ys = [];
        $coordLines = explode("\n", $this->input);
        foreach (array_slice($coordLines, 0, 1024) as $coordLine) {
            [$x, $y] = explode(',', trim($coordLine));
            $xs[] = (int) $x;
            $ys[] = (int) $y;
        }
    
        $map = new TableStr(array_fill(0, max($ys) + 1, array_fill(0, max($xs) + 1, '.')));
        foreach ($xs as $i => $_) {
            $map->set($ys[$i], $xs[$i], '#');
        }

        $sx = $sy = 0;
        $tx = $map->sizeX - 1;
        $ty = $map->sizeY - 1;
        $best = PHP_INT_MAX;
        $bestTo = [];
        for ($y = 0; $y < $map->sizeY; $y++) {
            for ($x = 0; $x < $map->sizeX; $x++) {
                $bestTo["$y,$x"] = PHP_INT_MAX;
            }
        }

        $this->walk($map, $tx, $ty, [$sy,$sx,0,[]], $best, $bestTo, $bestRoute);
        return new TaskOutput($best);
    }

    public function walk($map, $tx, $ty, $path, &$best, &$bestTo, &$bestRoute): void
    {
        [$y, $x, $score, $currentRoute] = $path;  
        $bestTo["$y,$x"] = $score;
        if ($score >= $best) {
            return;
        }

        if ($y == $ty && $x == $tx) {
            if ($best > $score) {
                $best = $score;
                $bestRoute = $currentRoute;
            }
            return;            
        }        

        $currentRoute["$x,$y"] = [$y, $x];
        $cardinals = [
            [1,0],
            [0,1],
            [-1,0],
            [0,-1],
        ];
        foreach ($cardinals as [$dy, $dx]) {
            $ny = $y + $dy;
            $nx = $x + $dx;
            if (
                !isset($currentRoute["$nx,$ny"]) &&
                $map->get($ny, $nx, '#') != '#' &&
                (($bestTo["$ny,$nx"] ?? PHP_INT_MAX) > $score + 1)
            ) {            
                $this->walk($map, $tx, $ty, [$ny, $nx, $score + 1, $currentRoute], $best, $bestTo, $bestRoute);
            }
        }
    }

    #[\Override] public function task2(): TaskOutput
    {
        $coords = [];
        $xs = [];
        $ys = [];
        $coordLines = array_map(fn($s) => trim($s), explode("\n", $this->input));
        $start = match(count($coordLines)) {
            25 => 12,
            default => 1024
        };
        foreach ($coordLines as $coordLine) {
            [$x, $y] = explode(',', trim($coordLine));
            $xs[] = (int) $x;
            $ys[] = (int) $y;
        }
        $map = new TableStr(array_fill(0, max($ys) + 1, array_fill(0, max($xs) + 1, '.')));

        for ($i = 0; $i < $start; $i++) {
            $map->set($ys[$i], $xs[$i], '#');
        }

        $sx = $sy = 0;
        $tx = $map->sizeX - 1;
        $ty = $map->sizeY - 1;
        $bestRoute = [];

        while ($i++ < count($coordLines)) {
            $map->set($ys[$i], $xs[$i], '#');            
            $best = PHP_INT_MAX;
            $bestTo = [];
            for ($y = 0; $y < $map->sizeY; $y++) {
                for ($x = 0; $x < $map->sizeX; $x++) {
                    $bestTo["$y,$x"] = PHP_INT_MAX;
                }
            }

            $this->walk($map, $tx, $ty, [$sy,$sx,0,[]], $best, $bestTo, $bestRoute);
            if ($best == PHP_INT_MAX) {
                return new TaskOutput($coordLines[$i]);
            }
            while (true) {
                if (! isset($bestRoute[$coordLines[$i+1]])) {
                    $i++;
                    $map->set($ys[$i], $xs[$i], '#');  
                } else {
                    break;
                }
            }
        }
        return new TaskOutput(0);
    }
};