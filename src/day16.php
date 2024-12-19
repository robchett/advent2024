<?php

namespace Robchett\Aoc2024;

use Robchett\Aoc2024\Input\TableStr;

/**
 * --- Day 16: Reindeer Maze ---
 * It's time again for the Reindeer Olympics! This year, the big event is the Reindeer Maze, where the Reindeer compete for the lowest score.
 * 
 * You and The Historians arrive to search for the Chief right as the event is about to start. It wouldn't hurt to watch a little, right?
 * 
 * The Reindeer start on the Start Tile (marked S) facing East and need to reach the End Tile (marked E). They can move forward one tile at a time (increasing their score by 1 point), but never into a wall (#). They can also rotate clockwise or counterclockwise 90 degrees at a time (increasing their score by 1000 points).
 * 
 * To figure out the best place to sit, you start by grabbing a map (your puzzle input) from a nearby kiosk. For example:
 * 
 * ###############
 * #.......#....E#
 * #.#.###.#.###.#
 * #.....#.#...#.#
 * #.###.#####.#.#
 * #.#.#.......#.#
 * #.#.#####.###.#
 * #...........#.#
 * ###.#.#####.#.#
 * #...#.....#.#.#
 * #.#.#.###.#.#.#
 * #.....#...#.#.#
 * #.###.#.#.#.#.#
 * #S..#.....#...#
 * ###############
 * There are many paths through this maze, but taking any of the best paths would incur a score of only 7036. This can be achieved by taking a total of 36 steps forward and turning 90 degrees a total of 7 times:
 * 
 * 
 * ###############
 * #.......#....E#
 * #.#.###.#.###^#
 * #.....#.#...#^#
 * #.###.#####.#^#
 * #.#.#.......#^#
 * #.#.#####.###^#
 * #..>>>>>>>>v#^#
 * ###^#.#####v#^#
 * #>>^#.....#v#^#
 * #^#.#.###.#v#^#
 * #^....#...#v#^#
 * #^###.#.#.#v#^#
 * #S..#.....#>>^#
 * ###############
 * Here's a second example:
 * 
 * #################
 * #...#...#...#..E#
 * #.#.#.#.#.#.#.#.#
 * #.#.#.#...#...#.#
 * #.#.#.#.###.#.#.#
 * #...#.#.#.....#.#
 * #.#.#.#.#.#####.#
 * #.#...#.#.#.....#
 * #.#.#####.#.###.#
 * #.#.#.......#...#
 * #.#.###.#####.###
 * #.#.#...#.....#.#
 * #.#.#.#####.###.#
 * #.#.#.........#.#
 * #.#.#.#########.#
 * #S#.............#
 * #################
 * In this maze, the best paths cost 11048 points; following one such path would look like this:
 * 
 * #################
 * #...#...#...#..E#
 * #.#.#.#.#.#.#.#^#
 * #.#.#.#...#...#^#
 * #.#.#.#.###.#.#^#
 * #>>v#.#.#.....#^#
 * #^#v#.#.#.#####^#
 * #^#v..#.#.#>>>>^#
 * #^#v#####.#^###.#
 * #^#v#..>>>>^#...#
 * #^#v###^#####.###
 * #^#v#>>^#.....#.#
 * #^#v#^#####.###.#
 * #^#v#^........#.#
 * #^#v#^#########.#
 * #S#>>^..........#
 * #################
 * Note that the path shown above includes one 90 degree turn as the very first move, rotating the Reindeer from facing East to facing North.
 * 
 * Analyze your map carefully. What is the lowest score a Reindeer could possibly get?
 * 
  * --- Part Two ---
 * Now that you know what the best paths look like, you can figure out the best spot to sit.
 * 
 * Every non-wall tile (S, ., or E) is equipped with places to sit along the edges of the tile. While determining which of these tiles would be the best spot to sit depends on a whole bunch of factors (how comfortable the seats are, how far away the bathrooms are, whether there's a pillar blocking your view, etc.), the most important factor is whether the tile is on one of the best paths through the maze. If you sit somewhere else, you'd miss all the action!
 * 
 * So, you'll need to determine which tiles are part of any best path through the maze, including the S and E tiles.
 * 
 * In the first example, there are 45 tiles (marked O) that are part of at least one of the various best paths through the maze:
 * 
 * ###############
 * #.......#....O#
 * #.#.###.#.###O#
 * #.....#.#...#O#
 * #.###.#####.#O#
 * #.#.#.......#O#
 * #.#.#####.###O#
 * #..OOOOOOOOO#O#
 * ###O#O#####O#O#
 * #OOO#O....#O#O#
 * #O#O#O###.#O#O#
 * #OOOOO#...#O#O#
 * #O###.#.#.#O#O#
 * #O..#.....#OOO#
 * ###############
 * In the second example, there are 64 tiles that are part of at least one of the best paths:
 * 
 * #################
 * #...#...#...#..O#
 * #.#.#.#.#.#.#.#O#
 * #.#.#.#...#...#O#
 * #.#.#.#.###.#.#O#
 * #OOO#.#.#.....#O#
 * #O#O#.#.#.#####O#
 * #O#O..#.#.#OOOOO#
 * #O#O#####.#O###O#
 * #O#O#..OOOOO#OOO#
 * #O#O###O#####O###
 * #O#O#OOO#..OOO#.#
 * #O#O#O#####O###.#
 * #O#O#OOOOOOO..#.#
 * #O#O#O#########.#
 * #O#OOO..........#
 * #################
 * Analyze your map further. How many tiles are part of at least one of the best paths through the maze?
 * @template-implements Task<int, list<string>>
 */
return new class($input) implements Task {

    public TableStr $map;
    public int $best;
    public array $bestPaths;

    #[\Override] function __construct(string $input)
    {
        $input = explode("\n", trim($input));
        $map = array_map(fn(string $i) => str_split(trim($i)), $input);
        $this->map = new TableStr($map);

        [$sy, $sx] = $this->map->find("S")[0];
        [$ty, $tx] = $this->map->find("E")[0];
        $best = PHP_INT_MAX;
        $bests = [];
        $bestTo = [];
        for ($y = 0; $y < $this->map->sizeY; $y++) {
            for ($x = 0; $x < $this->map->sizeX; $x++) {
                foreach (['^', '>', 'V', '<'] as $d) {
                    $bestTo["$y,$x,$d"] = PHP_INT_MAX;
                }
            }
        }
        $paths = [[$sy,$sx,'>',0,[]]];

        do {
            [$y, $x, $o, $score, $currentRoute] = array_pop($paths);
            if ($bestTo["$y,$x,$o"] < $score || $score > $best) {
                continue;
            }
            $bestTo["$y,$x,$o"] = $score;

            if ($y == $ty && $x == $tx) {
                $count = count($paths);
                print_r("Optimizing - $count remaining\n");
                if ($best > $score) {
                    $best = $score;
                    $bests = [$currentRoute];
                } else {
                    $bests[] = $currentRoute;
                }
                $count = count($paths);
                continue;            
            }

            $currentRoute[] = [$y, $x, $o];
            [$dy, $dx, $d1, $d2, $d3] = match($o) {
                '>' => [0, 1, '^', 'V', '<'],
                'V' => [1, 0, '>', '<', '^'],
                '<' => [0, -1, 'V', '^', '>'],
                '^' => [-1, 0, '<', '>', 'V'],
            };
            if (
                (!isset($paths[($y + $dy) . "," . ($x + $dx) . ",$d"]) || $paths[($y + $dy) . "," . ($x + $dx) . ",$d"][3] >= $score + 1000)
                && $this->map->get($y + $dy, $x + $dx, '#') != '#'
            ) {            
                $paths[] = [$y + $dy, $x + $dx, $o, $score + 1, $currentRoute];
            }
            if (!isset($paths["$y,$x,$d1"]) || $paths["$y,$x,$d1"][3] >= $score + 1000) {
                $paths["$y,$x,$d1"] = [$y, $x, $d1, $score + 1000, $currentRoute];
            }
            if (!isset($paths["$y,$x,$d2"]) || $paths["$y,$x,$d2"][3] >= $score + 1000) {
                $paths["$y,$x,$d2"] = [$y, $x, $d2, $score + 1000, $currentRoute];
            }
            if (!isset($paths["$y,$x,$d3"]) || $paths["$y,$x,$d3"][3] >= $score + 1000) {
                $paths["$y,$x,$d3"] = [$y, $x, $d3, $score + 3000, $currentRoute];
            }

        } while($paths);

        $this->best = $best;
        $this->bestPaths = $bests;
    }

    #[\Override] public function task1(): TaskOutput
    {       
        return new TaskOutput($this->best);
    }

    #[\Override] public function task2(): TaskOutput
    {
        $uniqueNodes = [];
        foreach($this->bestPaths as $path) {
            foreach ($path as [$y,$x]) {
                $uniqueNodes["$y,$x"] = [$y,$x];
            }
        }
        
        return new TaskOutput(count($uniqueNodes) + 1);
    }
};