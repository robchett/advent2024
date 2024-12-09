<?php

namespace Robchett\Aoc2024;

use Robchett\Aoc2024\Input\TableStr;

/**
 * --- Day 8: Resonant Collinearity ---
 * You find yourselves on the roof of a top-secret Easter Bunny installation.
 * 
 * While The Historians do their thing, you take a look at the familiar huge antenna. Much to your surprise, it seems to have been reconfigured to emit a signal that makes people 0.1% more likely to buy Easter Bunny brand Imitation Mediocre Chocolate as a Christmas gift! Unthinkable!
 * 
 * Scanning across the city, you find that there are actually many such antennas. Each antenna is tuned to a specific frequency indicated by a single lowercase letter, uppercase letter, or digit. You create a map (your puzzle input) of these antennas. For example:
 * 
 * ............
 * ........0...
 * .....0......
 * .......0....
 * ....0.......
 * ......A.....
 * ............
 * ............
 * ........A...
 * .........A..
 * ............
 * ............
 * The signal only applies its nefarious effect at specific antinodes based on the resonant frequencies of the antennas. In particular, an antinode occurs at any point that is perfectly in line with two antennas of the same frequency - but only when one of the antennas is twice as far away as the other. This means that for any pair of antennas with the same frequency, there are two antinodes, one on either side of them.
 * 
 * So, for these two antennas with frequency a, they create the two antinodes marked with #:
 * 
 * ..........
 * ...#......
 * ..........
 * ....a.....
 * ..........
 * .....a....
 * ..........
 * ......#...
 * ..........
 * ..........
 * Adding a third antenna with the same frequency creates several more antinodes. It would ideally add four antinodes, but two are off the right side of the map, so instead it adds only two:
 * 
 * ..........
 * ...#......
 * #.........
 * ....a.....
 * ........a.
 * .....a....
 * ..#.......
 * ......#...
 * ..........
 * ..........
 * Antennas with different frequencies don't create antinodes; A and a count as different frequencies. However, antinodes can occur at locations that contain antennas. In this diagram, the lone antenna with frequency capital A creates no antinodes but has a lowercase-a-frequency antinode at its location:
 * 
 * ..........
 * ...#......
 * #.........
 * ....a.....
 * ........a.
 * .....a....
 * ..#.......
 * ......A...
 * ..........
 * ..........
 * The first example has antennas with two different frequencies, so the antinodes they create look like this, plus an antinode overlapping the topmost A-frequency antenna:
 * 
 * ......#....#
 * ...#....0...
 * ....#0....#.
 * ..#....0....
 * ....0....#..
 * .#....A.....
 * ...#........
 * #......#....
 * ........A...
 * .........A..
 * ..........#.
 * ..........#.
 * Because the topmost A-frequency antenna overlaps with a 0-frequency antinode, there are 14 total unique locations that contain an antinode within the bounds of the map.
 * 
 * Calculate the impact of the signal. How many unique locations within the bounds of the map contain an antinode?
 * 
 * --- Part Two ---
* Watching over your shoulder as you work, one of The Historians asks if you took the effects of resonant harmonics into your calculations.
* 
* Whoops!
* 
* After updating your model, it turns out that an antinode occurs at any grid position exactly in line with at least two antennas of the same frequency, regardless of distance. This means that some of the new antinodes will occur at the position of each antenna (unless that antenna is the only one of its frequency).
* 
* So, these three T-frequency antennas now create many antinodes:
* 
* T....#....
* ...T......
* .T....#...
* .........#
* ..#.......
* ..........
* ...#......
* ..........
* ....#.....
* ..........
* In fact, the three T-frequency antennas are all exactly in line with two antennas, so they are all also antinodes! This brings the total number of antinodes in the above example to 9.
* 
* The original example now has 34 antinodes, including the antinodes that appear on every antenna:
* 
* ##....#....#
* .#.#....0...
* ..#.#0....#.
* ..##...0....
* ....0....#..
* .#...#A....#
* ...#..#.....
* #....#.#....
* ..#.....A...
* ....#....A..
* .#........#.
* ...#......##
* Calculate the impact of the signal using this updated model. How many unique locations within the bounds of the map contain an antinode?
 * @template-implements Task<int, list<string>>
 */
return new class($input) implements Task {

    protected TableStr $input;

    #[\Override] function __construct(string $input)
    {
        $this->input = TableStr::parse($input);
    }

    #[\Override] public function task1(): TaskOutput
    {
        $positions = [];
        $antinodes = [];

        for($y = 0; $y < $this->input->sizeY; $y++) {
            for($x = 0; $x < $this->input->sizeX; $x++) {
                $nodeVal = $this->input[$y][$x];
                if ($nodeVal == '.') {
                    continue;
                }
                $positions[$nodeVal] ??= [];
                foreach ($positions[$nodeVal] as $p) {
                    $dy = $y - $p[0];
                    $dx = $x - $p[1];

                    $ny = $p[0] - $dy;
                    $nx = $p[1] - $dx;
                    if ($nx < $this->input->sizeX && $nx >= 0 && $ny < $this->input->sizeY && $ny >= 0) {
                        $antinodes["$ny,$nx"] = true; 
                    }
                    $ny = $y + $dy;
                    $nx = $x + $dx;
                    if ($nx < $this->input->sizeX && $nx >= 0 && $ny < $this->input->sizeY && $ny >= 0) {
                        $antinodes["$ny,$nx"] = true; 
                    }                    
                }
                $positions[$nodeVal][] = [$y, $x];
            } 
        } 

        return new TaskOutput(count($antinodes));
    }

    #[\Override] public function task2(): TaskOutput
    {
        $positions = [];
        $antinodes = [];

        for($y = 0; $y < $this->input->sizeY; $y++) {
            for($x = 0; $x < $this->input->sizeX; $x++) {
                $nodeVal = $this->input[$y][$x];
                if ($nodeVal == '.') {
                    continue;
                }
                $positions[$nodeVal] ??= [];
                foreach ($positions[$nodeVal] as $p) {
                    $dy = $y - $p[0];
                    $dx = $x - $p[1];

                    [$dy, $dx] = $this->reduceFraction($dy, $dx);
         
                    $i = 0;
                    while(true) {
                        $ny = $y + ($dy * $i);
                        $nx = $x + ($dx * $i);
                        if ($nx < $this->input->sizeX && $nx >= 0 && $ny < $this->input->sizeY && $ny >= 0) {
                            $antinodes["$ny,$nx"] = true; 
                        } else {
                            break;
                        }
                        $i++;
                    }  
                    $i = 1;
                    while(true) {
                        $ny = $y - ($dy * $i);
                        $nx = $x - ($dx * $i);
                        if ($nx < $this->input->sizeX && $nx >= 0 && $ny < $this->input->sizeY && $ny >= 0) {
                            $antinodes["$ny,$nx"] = true; 
                        } else {
                            break;
                        }    
                        $i++; 
                    }           
                }
                $positions[$nodeVal][] = [$y, $x];
            } 
        } 

        return new TaskOutput(count($antinodes)); 
    }

    protected function reduceFraction(int $n, int $d): array
    {
      $gcd = $this->gcd($n, $d);
  
      return [$n / $gcd, $d / $gcd];
    }
  
  
    protected function gcd(int $a, int $b): int
    {
      return $b ? $this->gcd($b, $a % $b) : $a;
    }
};