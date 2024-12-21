<?php

namespace Robchett\Aoc2024;

use Robchett\Aoc2024\Input\TableStr;

/**
 * --- Day 20: Race Condition ---
 * The Historians are quite pixelated again. This time, a massive, black building looms over you - you're right outside the CPU!
 * 
 * While The Historians get to work, a nearby program sees that you're idle and challenges you to a race. Apparently, you've arrived just in time for the frequently-held race condition festival!
 * 
 * The race takes place on a particularly long and twisting code path; programs compete to see who can finish in the fewest picoseconds. The winner even gets their very own mutex!
 * 
 * They hand you a map of the racetrack (your puzzle input). For example:
 * 
 * ###############
 * #...#...#.....#
 * #.#.#.#.#.###.#
 * #S#...#.#.#...#
 * #######.#.#.###
 * #######.#.#...#
 * #######.#.###.#
 * ###..E#...#...#
 * ###.#######.###
 * #...###...#...#
 * #.#####.#.###.#
 * #.#...#.#.#...#
 * #.#.#.#.#.#.###
 * #...#...#...###
 * ###############
 * The map consists of track (.) - including the start (S) and end (E) positions (both of which also count as track) - and walls (#).
 * 
 * When a program runs through the racetrack, it starts at the start position. Then, it is allowed to move up, down, left, or right; each such move takes 1 picosecond. The goal is to reach the end position as quickly as possible. In this example racetrack, the fastest time is 84 picoseconds.
 * 
 * Because there is only a single path from the start to the end and the programs all go the same speed, the races used to be pretty boring. To make things more interesting, they introduced a new rule to the races: programs are allowed to cheat.
 * 
 * The rules for cheating are very strict. Exactly once during a race, a program may disable collision for up to 2 picoseconds. This allows the program to pass through walls as if they were regular track. At the end of the cheat, the program must be back on normal track again; otherwise, it will receive a segmentation fault and get disqualified.
 * 
 * So, a program could complete the course in 72 picoseconds (saving 12 picoseconds) by cheating for the two moves marked 1 and 2:
 * 
 * ###############
 * #...#...12....#
 * #.#.#.#.#.###.#
 * #S#...#.#.#...#
 * #######.#.#.###
 * #######.#.#...#
 * #######.#.###.#
 * ###..E#...#...#
 * ###.#######.###
 * #...###...#...#
 * #.#####.#.###.#
 * #.#...#.#.#...#
 * #.#.#.#.#.#.###
 * #...#...#...###
 * ###############
 * Or, a program could complete the course in 64 picoseconds (saving 20 picoseconds) by cheating for the two moves marked 1 and 2:
 * 
 * ###############
 * #...#...#.....#
 * #.#.#.#.#.###.#
 * #S#...#.#.#...#
 * #######.#.#.###
 * #######.#.#...#
 * #######.#.###.#
 * ###..E#...12..#
 * ###.#######.###
 * #...###...#...#
 * #.#####.#.###.#
 * #.#...#.#.#...#
 * #.#.#.#.#.#.###
 * #...#...#...###
 * ###############
 * This cheat saves 38 picoseconds:
 * 
 * ###############
 * #...#...#.....#
 * #.#.#.#.#.###.#
 * #S#...#.#.#...#
 * #######.#.#.###
 * #######.#.#...#
 * #######.#.###.#
 * ###..E#...#...#
 * ###.####1##.###
 * #...###.2.#...#
 * #.#####.#.###.#
 * #.#...#.#.#...#
 * #.#.#.#.#.#.###
 * #...#...#...###
 * ###############
 * This cheat saves 64 picoseconds and takes the program directly to the end:
 * 
 * ###############
 * #...#...#.....#
 * #.#.#.#.#.###.#
 * #S#...#.#.#...#
 * #######.#.#.###
 * #######.#.#...#
 * #######.#.###.#
 * ###..21...#...#
 * ###.#######.###
 * #...###...#...#
 * #.#####.#.###.#
 * #.#...#.#.#...#
 * #.#.#.#.#.#.###
 * #...#...#...###
 * ###############
 * Each cheat has a distinct start position (the position where the cheat is activated, just before the first move that is allowed to go through walls) and end position; cheats are uniquely identified by their start position and end position.
 * 
 * In this example, the total number of cheats (grouped by the amount of time they save) are as follows:
 * 
 * There are 14 cheats that save 2 picoseconds.
 * There are 14 cheats that save 4 picoseconds.
 * There are 2 cheats that save 6 picoseconds.
 * There are 4 cheats that save 8 picoseconds.
 * There are 2 cheats that save 10 picoseconds.
 * There are 3 cheats that save 12 picoseconds.
 * There is one cheat that saves 20 picoseconds.
 * There is one cheat that saves 36 picoseconds.
 * There is one cheat that saves 38 picoseconds.
 * There is one cheat that saves 40 picoseconds.
 * There is one cheat that saves 64 picoseconds.
 * You aren't sure what the conditions of the racetrack will be like, so to give yourself as many options as possible, you'll need a list of the best cheats. How many cheats would save you at least 100 picoseconds?
*  
*  --- Part Two ---
* The programs seem perplexed by your list of cheats. Apparently, the two-picosecond cheating rule was deprecated several milliseconds ago! The latest version of the cheating rule permits a single cheat that instead lasts at most 20 picoseconds.
* 
* Now, in addition to all the cheats that were possible in just two picoseconds, many more cheats are possible. This six-picosecond cheat saves 76 picoseconds:
* 
* ###############
* #...#...#.....#
* #.#.#.#.#.###.#
* #S#...#.#.#...#
* #1#####.#.#.###
* #2#####.#.#...#
* #3#####.#.###.#
* #456.E#...#...#
* ###.#######.###
* #...###...#...#
* #.#####.#.###.#
* #.#...#.#.#...#
* #.#.#.#.#.#.###
* #...#...#...###
* ###############
* Because this cheat has the same start and end positions as the one above, it's the same cheat, even though the path taken during the cheat is different:
* 
* ###############
* #...#...#.....#
* #.#.#.#.#.###.#
* #S12..#.#.#...#
* ###3###.#.#.###
* ###4###.#.#...#
* ###5###.#.###.#
* ###6.E#...#...#
* ###.#######.###
* #...###...#...#
* #.#####.#.###.#
* #.#...#.#.#...#
* #.#.#.#.#.#.###
* #...#...#...###
* ###############
* Cheats don't need to use all 20 picoseconds; cheats can last any amount of time up to and including 20 picoseconds (but can still only end when the program is on normal track). Any cheat time not used is lost; it can't be saved for another cheat later.
* 
* You'll still need a list of the best cheats, but now there are even more to choose between. Here are the quantities of cheats in this example that save 50 picoseconds or more:
* 
* There are 32 cheats that save 50 picoseconds.
* There are 31 cheats that save 52 picoseconds.
* There are 29 cheats that save 54 picoseconds.
* There are 39 cheats that save 56 picoseconds.
* There are 25 cheats that save 58 picoseconds.
* There are 23 cheats that save 60 picoseconds.
* There are 20 cheats that save 62 picoseconds.
* There are 19 cheats that save 64 picoseconds.
* There are 12 cheats that save 66 picoseconds.
* There are 14 cheats that save 68 picoseconds.
* There are 12 cheats that save 70 picoseconds.
* There are 22 cheats that save 72 picoseconds.
* There are 4 cheats that save 74 picoseconds.
* There are 3 cheats that save 76 picoseconds.
* Find the best cheats using the updated cheating rules. How many cheats would save you at least 100 picoseconds?
 * @template-implements Task<int, list<string>>
 */
return new class($input) implements Task {

    public TableStr $map;

    #[\Override] function __construct(string $input)
    {
        $map = [];
        $input = explode("\n", trim($input));
        foreach ($input as $i) {
            $map[] = str_split(trim($i));
        }
        $this->map = new TableStr($map);
    }

    #[\Override] public function task1(): TaskOutput
    {
        [$sy, $sx] = $this->map->find('E')[0];
        [$ty, $tx] = $this->map->find('S')[0];
        $max = match ($this->map->sizeY) {
            15 => 0,
            default => 100
        };

        $best = PHP_INT_MAX;
        $bestTo = [];
        for ($y = 0; $y < $this->map->sizeY; $y++) {
            for ($x = 0; $x < $this->map->sizeX; $x++) {
                $bestTo["$y,$x"] = PHP_INT_MAX;
            }
        }

        $this->walk($this->map, $tx, $ty, $sx, $sy, $best, $bestTo);

        $cardinals = [
            [1,0],
            [0,1],
            [-1,0],
            [0,-1],
        ];
        $savings = [];
        for ($y = 1; $y < $this->map->sizeY - 1; $y++) {
            for ($x = 1; $x < $this->map->sizeX - 1; $x++) {
                $v = $bestTo["$y,$x"];
                if ($v == PHP_INT_MAX) {
                    continue;
                }
                foreach ($cardinals as [$dy, $dx]) {
                    $y1 = $y + $dy;
                    $y2 = $y1 + $dy;
                    $x1 = $x + $dx;
                    $x2 = $x1 + $dx;
                    $v1 = $bestTo["$y1,$x1"] ?? PHP_INT_MAX;
                    $v2 = $bestTo["$y2,$x2"] ?? PHP_INT_MAX;

                    if ($v1 == PHP_INT_MAX && $v2 + 1 <= $v) {
                        $diff = $v - $v2 - 2;
                        if ($diff >= $max) {
                            $savings[] = "$y,$x -> $y2,$x2 = $diff";
                        }
                    }
                }
            }
        }

        return new TaskOutput(count($savings));
    }

    public function walk($map, $tx, $ty, $sx, $sy, &$best, &$bestTo, $walls = '#'): void
    {
        $paths = [[$sy,$sx,0,[]]];
        while ($paths) {
            [$y, $x, $score, $currentRoute] = array_pop($paths);  
            $bestTo["$y,$x"] = $score;

            if ($y == $ty && $x == $tx) {
                if ($best > $score) {
                    $best = $score;
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
                    $map->get($ny, $nx, $walls) != $walls &&
                    (($bestTo["$ny,$nx"] ?? PHP_INT_MAX) > $score + 1)
                ) {          
                    $paths[] = [$ny, $nx, $score + 1, $currentRoute];
                }
            }
        }
    }

    #[\Override] public function task2(): TaskOutput
    {
        [$sy, $sx] = $this->map->find('E')[0];
        [$ty, $tx] = $this->map->find('S')[0];
        $max = match ($this->map->sizeY) {
            15 => 50,
            default => 100
        };
        $this->map->set($sy, $sx, '.');
        $this->map->set($ty, $tx, '.');


        $best = PHP_INT_MAX;
        $bestTo = [];
        for ($y = 0; $y < $this->map->sizeY; $y++) {
            for ($x = 0; $x < $this->map->sizeX; $x++) {
                $bestTo["$y,$x"] = PHP_INT_MAX;
            }
        }

        $this->walk($this->map, $tx, $ty, $sx, $sy, $best, $bestTo);

        $cardinals = [
            [1,0],
            [0,1],
            [-1,0],
            [0,-1],
        ];
        $savings = [];
        for ($y = 1; $y < $this->map->sizeY - 1; $y++) {
            for ($x = 1; $x < $this->map->sizeX - 1; $x++) {
                $v = $bestTo["$y,$x"];
                if ($v == PHP_INT_MAX) {
                    continue;
                }

                $seen = ["$y,$x" => true];
                $paths = [];
                $paths[] = [$y,$x, 0];
                while ($paths) {
                    [$cy, $cx, $steps] = array_shift($paths);   
                    foreach ($cardinals as [$dy, $dx]) {
                        $ny = $cy + $dy;
                        $nx = $cx + $dx;
                        if (isset($seen["$ny,$nx"])) {
                            continue;
                        }
                        if ($steps != 0 && $this->map->get($ny, $nx, '-') == '.') {  
                            $v1 = $bestTo["$ny,$nx"];
                            $diff = $v - $v1 - $steps - 1;   
                            if ($diff >= $max) {
                                $savings["($y,$x)[$v] -> ($ny,$nx)[$v1]"] = $diff;
                            }
                        }
                        $seen["$ny,$nx"] = true;
                        if ($steps != 19 && $this->map->get($ny, $nx, '-') != '-') {
                            $paths[] = [$ny, $nx, $steps + 1];
                        }
                    }
                }   
            }
        }

        return new TaskOutput(count($savings));  
      }
};