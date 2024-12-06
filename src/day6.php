<?php

namespace Robchett\Aoc2024;

use Robchett\Aoc2024\Input\Map;


/**
 * tests/Day5Test.php--- Day 6: Guard Gallivant ---
 * The Historians use their fancy device again, this time to whisk you all away to the North Pole prototype suit manufacturing lab... in the year 1518! It turns out that having direct access to history is very convenient for a group of historians.
 * 
 * You still have to be careful of time paradoxes, and so it will be important to avoid anyone from 1518 while The Historians search for the Chief. Unfortunately, a single guard is patrolling this part of the lab.
 * 
 * Maybe you can work out where the guard will go ahead of time so that The Historians can search safely?
 * 
 * You start by making a map (your puzzle input) of the situation. For example:
 * 
 * ....#.....
 * .........#
 * ..........
 * ..#.......
 * .......#..
 * ..........
 * .#..^.....
 * ........#.
 * #.........
 * ......#...
 * The map shows the current position of the guard with ^ (to indicate the guard is currently facing up from the perspective of the map). Any obstructions - crates, desks, alchemical reactors, etc. - are shown as #.
 * 
 * Lab guards in 1518 follow a very strict patrol protocol which involves repeatedly following these steps:
 * 
 * If there is something directly in front of you, turn right 90 degrees.
 * Otherwise, take a step forward.
 * Following the above protocol, the guard moves up several times until she reaches an obstacle (in this case, a pile of failed suit prototypes):
 * 
 * ....#.....
 * ....^....#
 * ..........
 * ..#.......
 * .......#..
 * ..........
 * .#........
 * ........#.
 * #.........
 * ......#...
 * Because there is now an obstacle in front of the guard, she turns right before continuing straight in her new facing direction:
 * 
 * ....#.....
 * ........>#
 * ..........
 * ..#.......
 * .......#..
 * ..........
 * .#........
 * ........#.
 * #.........
 * ......#...
 * Reaching another obstacle (a spool of several very long polymers), she turns right again and continues downward:
 * 
 * ....#.....
 * .........#
 * ..........
 * ..#.......
 * .......#..
 * ..........
 * .#......v.
 * ........#.
 * #.........
 * ......#...
 * This process continues for a while, but the guard eventually leaves the mapped area (after walking past a tank of universal solvent):
 * 
 * ....#.....
 * .........#
 * ..........
 * ..#.......
 * .......#..
 * ..........
 * .#........
 * ........#.
 * #.........
 * ......#v..
 * By predicting the guard's route, you can determine which specific positions in the lab will be in the patrol path. Including the guard's starting position, the positions visited by the guard before leaving the area are marked with an X:
 * 
 * ....#.....
 * ....XXXXX#
 * ....X...X.
 * ..#.X...X.
 * ..XXXXX#X.
 * ..X.X.X.X.
 * .#XXXXXXX.
 * .XXXXXXX#.
 * #XXXXXXX..
 * ......#X..
 * In this example, the guard will visit 41 distinct positions on your map.
 * 
 * Predict the path of the guard. How many distinct positions will the guard visit before leaving the mapped area?
 * 
 * 
 * --- Part Two ---
 * While The Historians begin working around the guard's patrol route, you borrow their fancy device and step outside the lab. From the safety of a supply closet, you time travel through the last few months and record the nightly status of the lab's guard post on the walls of the closet.
 * 
 * Returning after what seems like only a few seconds to The Historians, they explain that the guard's patrol area is simply too large for them to safely search the lab without getting caught.
 * 
 * Fortunately, they are pretty sure that adding a single new obstruction won't cause a time paradox. They'd like to place the new obstruction in such a way that the guard will get stuck in a loop, making the rest of the lab safe to search.
 * 
 * To have the lowest chance of creating a time paradox, The Historians would like to know all of the possible positions for such an obstruction. The new obstruction can't be placed at the guard's starting position - the guard is there right now and would notice.
 * 
 * In the above example, there are only 6 different positions where a new obstruction would cause the guard to get stuck in a loop. The diagrams of these six situations use O to mark the new obstruction, | to show a position where the guard moves up/down, - to show a position where the guard moves left/right, and + to show a position where the guard moves both up/down and left/right.
 * 
 * Option one, put a printing press next to the guard's starting position:
 * 
 * ....#.....
 * ....+---+#
 * ....|...|.
 * ..#.|...|.
 * ....|..#|.
 * ....|...|.
 * .#.O^---+.
 * ........#.
 * #.........
 * ......#...
 * Option two, put a stack of failed suit prototypes in the bottom right quadrant of the mapped area:
 * 
 * 
 * ....#.....
 * ....+---+#
 * ....|...|.
 * ..#.|...|.
 * ..+-+-+#|.
 * ..|.|.|.|.
 * .#+-^-+-+.
 * ......O.#.
 * #.........
 * ......#...
 * Option three, put a crate of chimney-squeeze prototype fabric next to the standing desk in the bottom right quadrant:
 * 
 * ....#.....
 * ....+---+#
 * ....|...|.
 * ..#.|...|.
 * ..+-+-+#|.
 * ..|.|.|.|.
 * .#+-^-+-+.
 * .+----+O#.
 * #+----+...
 * ......#...
 * Option four, put an alchemical retroencabulator near the bottom left corner:
 * 
 * ....#.....
 * ....+---+#
 * ....|...|.
 * ..#.|...|.
 * ..+-+-+#|.
 * ..|.|.|.|.
 * .#+-^-+-+.
 * ..|...|.#.
 * #O+---+...
 * ......#...
 * Option five, put the alchemical retroencabulator a bit to the right instead:
 * 
 * ....#.....
 * ....+---+#
 * ....|...|.
 * ..#.|...|.
 * ..+-+-+#|.
 * ..|.|.|.|.
 * .#+-^-+-+.
 * ....|.|.#.
 * #..O+-+...
 * ......#...
 * Option six, put a tank of sovereign glue right next to the tank of universal solvent:
 * 
 * ....#.....
 * ....+---+#
 * ....|...|.
 * ..#.|...|.
 * ..+-+-+#|.
 * ..|.|.|.|.
 * .#+-^-+-+.
 * .+----++#.
 * #+----++..
 * ......#O..
 * It doesn't really matter what you choose to use as an obstacle so long as you and The Historians can put it into position without the guard noticing. The important thing is having enough options that you can find one that minimizes time paradoxes, and in this example, there are 6 different positions you could choose.
 * 
 * You need to get the guard stuck in a loop by adding a single new obstruction. How many different positions could you choose for this obstruction?
 * @template-implements Task<int, list<string>>
 */
return new class($input) implements Task {

    public $cols;
    public $rows;
    public $guard;


    #[\Override] function __construct(string $input)
    {
        $cells = str_split($input);
        $cells = array_values(array_filter($cells, fn($s) =>  $s != "\r"));

        $colsCount = array_search("\n", $cells);
        $cells = array_values(array_filter($cells, fn($s) => $s != "\n"));
        $rowsCount = count($cells) / $colsCount;
 
        $col = [];
        $rows = [];
        $guard = null;

        for($col = 0; $col < $colsCount; $col++) {
            for ($row = 0; $row < $rowsCount; $row++) {
                if ($cells[$col + $colsCount*$row] == '#') {
                    $cols[$col][] = $row;
                    $rows[$row][] = $col;
                    continue;
                }
                if ($cells[$col + $colsCount*$row] == '.') {
                    continue;
                }
                $guard ??= [$col, $row, $cells[$col + $colsCount*$row]];
            }
        }
        $this->guard = $guard;
        $this->cols = $cols;
        $this->colsCount = $colsCount;
        $this->rows = $rows;
        $this->rowsCount = $rowsCount;
    }

    public function prev(array $a, int $key): int 
    {
        foreach (array_reverse($a) as $b) {
            if ($b < $key) { return $b + 1; }
        }
        return -1;
    }

    public function next(array $a, int $key, int $max): int 
    {
        foreach ($a as $b) {
            if ($b > $key) { return $b - 1; }
        }
        return $max;
    }

    #[\Override] public function task1(): TaskOutput
    {
        $guard = $this->guard;
        $guardPositions = ["$guard[0],$guard[1]" => true];
        while(true) {
            $newGuard = match($guard[2]) {
                "^" => [$guard[0], $this->prev($this->cols[$guard[0]], $guard[1]), '>'],
                ">" => [$this->next($this->rows[$guard[1]], $guard[0], $this->colsCount), $guard[1], 'V'],
                "V" => [$guard[0], $this->next($this->cols[$guard[0]], $guard[1], $this->rowsCount), '<'],
                "<" => [$this->prev($this->rows[$guard[1]], $guard[0]), $guard[1], '^'],
            };
            foreach (range($guard[0], $newGuard[0]) as $col) {
                foreach (range($guard[1], $newGuard[1]) as $row) {
                    $guardPositions["$col,$row"] = true;
                }
            }
            if (
                 $newGuard[0] == $this->colsCount ||
                 $newGuard[0] == -1 ||
                 $newGuard[1] == $this->rowsCount ||
                 $newGuard[1] == -1
                ) {
                break;
            }
            $guard = $newGuard;
        }
        return new TaskOutput(count($guardPositions) - 1);
    }

    #[\Override] public function task2(): TaskOutput
    {
        $guard = $this->guard;
        $guardPositions = ["$guard[0],$guard[1]" => []];
        while(true) {
            $newGuard = match($guard[2]) {
                "^" => [$guard[0], $this->prev($this->cols[$guard[0]], $guard[1]), '>'],
                ">" => [$this->next($this->rows[$guard[1]], $guard[0], $this->colsCount), $guard[1], 'V'],
                "V" => [$guard[0], $this->next($this->cols[$guard[0]], $guard[1], $this->rowsCount), '<'],
                "<" => [$this->prev($this->rows[$guard[1]], $guard[0]), $guard[1], '^'],
            };
            foreach (range($guard[0], $newGuard[0]) as $col) {
                foreach (range($guard[1], $newGuard[1]) as $row) {
                    $guardPositions["$col,$row"] ??= [$col, $row];
                }
            }
            if (
                 $newGuard[0] == $this->colsCount ||
                 $newGuard[0] == -1 ||
                 $newGuard[1] == $this->rowsCount ||
                 $newGuard[1] == -1
                ) {
                break;
            }
            $guard = $newGuard;
        }
        unset($guardPositions["{$this->guard[0]},{$this->guard[1]}"]);

        $loops = 0;
        foreach ($guardPositions as [$col, $row]) {
            $guard = $this->guard;
            $newCols = $this->cols;
            $newCols[$col][] = $row;
            sort($newCols[$col]);
            $newRows = $this->rows;
            $newRows[$row][] = $col;
            sort($newRows[$row]);

            $guardPositions = ["$guard[0],$guard[1],$guard[2]" => true];
            $i = 0;
            while(true) {
                $guard = match($guard[2]) {
                    "^" => [$guard[0], $this->prev($newCols[$guard[0]] ?? [], $guard[1]), '>'],
                    ">" => [$this->next($newRows[$guard[1]] ?? [], $guard[0], $this->colsCount), $guard[1], 'V'],
                    "V" => [$guard[0], $this->next($newCols[$guard[0]] ?? [], $guard[1], $this->rowsCount), '<'],
                    "<" => [$this->prev($newRows[$guard[1]] ?? [], $guard[0]), $guard[1], '^'],
                };
                if (isset($guardPositions["$guard[0],$guard[1],$guard[2]"])) {
                    $loops++;
                    continue 2;
                }
                $guardPositions["$guard[0],$guard[1],$guard[2]"] = true;
                if (
                    $guard[0] == $this->colsCount ||
                    $guard[0] == -1 ||
                    $guard[1] == $this->rowsCount ||
                    $guard[1] == -1
                    ) {
                    continue 2;
                }
            }
        }        

        return new TaskOutput($loops);
    }
};

class OOB extends \Exception {};