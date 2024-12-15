<?php

namespace Robchett\Aoc2024;

use Robchett\Aoc2024\Input\TableStr;

/**
 * --- Day 15: Warehouse Woes ---
 * You appear back inside your own mini submarine! Each Historian drives their mini submarine in a different direction; maybe the Chief has his own submarine down here somewhere as well?
 * 
 * You look up to see a vast school of lanternfish swimming past you. On closer inspection, they seem quite anxious, so you drive your mini submarine over to see if you can help.
 * 
 * Because lanternfish populations grow rapidly, they need a lot of food, and that food needs to be stored somewhere. That's why these lanternfish have built elaborate warehouse complexes operated by robots!
 * 
 * These lanternfish seem so anxious because they have lost control of the robot that operates one of their most important warehouses! It is currently running amok, pushing around boxes in the warehouse with no regard for lanternfish logistics or lanternfish inventory management strategies.
 * 
 * Right now, none of the lanternfish are brave enough to swim up to an unpredictable robot so they could shut it off. However, if you could anticipate the robot's movements, maybe they could find a safe option.
 * 
 * The lanternfish already have a map of the warehouse and a list of movements the robot will attempt to make (your puzzle input). The problem is that the movements will sometimes fail as boxes are shifted around, making the actual movements of the robot difficult to predict.
 * 
 * For example:
 * 
 * ##########
 * #..O..O.O#
 * #......O.#
 * #.OO..O.O#
 * #..O@..O.#
 * #O#..O...#
 * #O..O..O.#
 * #.OO.O.OO#
 * #....O...#
 * ##########
 * 
 * <vv>^<v^>v>^vv^v>v<>v^v<v<^vv<<<^><<><>>v<vvv<>^v^>^<<<><<v<<<v^vv^v>^
 * vvv<<^>^v^^><<>>><>^<<><^vv^^<>vvv<>><^^v>^>vv<>v<<<<v<^v>^<^^>>>^<v<v
 * ><>vv>v^v^<>><>>>><^^>vv>v<^^^>>v^v^<^^>v^^>v^<^v>v<>>v^v^<v>v^^<^^vv<
 * <<v<^>>^^^^>>>v^<>vvv^><v<<<>^^^vv^<vvv>^>v<^^^^v<>^>vvvv><>>v^<<^^^^^
 * ^><^><>>><>^^<<^^v>>><^<v>^<vv>>v>>>^v><>^v><<<<v>>v<v<v>vvv>^<><<>^><
 * ^>><>^v<><^vvv<^^<><v<<<<<><^v<<<><<<^^<v<^^^><^>>^<v^><<<^>>^v<v^v<v^
 * >^>>^v>vv>^<<^v<>><<><<v<<v><>v<^vv<<<>^^v^>^^>>><<^v>>v^v><^^>>^<>vv^
 * <><^^>^^^<><vvvvv^v<v<<>^v<v>v<<^><<><<><<<^^<<<^<<>><<><^^^>^^<>^>v<>
 * ^^>vv<^v^v<vv>^<><v<^v>^^^>>>^^vvv^>vvv<>>>^<^>>>>>^<<^v>^vvv<>^<><<v>
 * v^^>>><<^^<>>^v^<v^vv<>v^<<>^<^v^v><^<<<><<^<v><v<>vv>>v><v^<vv<>v^<<^
 * As the robot (@) attempts to move, if there are any boxes (O) in the way, the robot will also attempt to push those boxes. However, if this action would cause the robot or a box to move into a wall (#), nothing moves instead, including the robot. The initial positions of these are shown on the map at the top of the document the lanternfish gave you.
 * 
 * The rest of the document describes the moves (^ for up, v for down, < for left, > for right) that the robot will attempt to make, in order. (The moves form a single giant sequence; they are broken into multiple lines just to make copy-pasting easier. Newlines within the move sequence should be ignored.)
 * 
 * Here is a smaller example to get started:
 * 
 * ########
 * #..O.O.#
 * ##@.O..#
 * #...O..#
 * #.#.O..#
 * #...O..#
 * #......#
 * ########
 * 
 * <^^>>>vv<v>>v<<
 * Were the robot to attempt the given sequence of moves, it would push around the boxes as follows:
 * 
 * Initial state:
 * ########
 * #..O.O.#
 * ##@.O..#
 * #...O..#
 * #.#.O..#
 * #...O..#
 * #......#
 * ########
 * 
 * Move <:
 * ########
 * #..O.O.#
 * ##@.O..#
 * #...O..#
 * #.#.O..#
 * #...O..#
 * #......#
 * ########
 * 
 * Move ^:
 * ########
 * #.@O.O.#
 * ##..O..#
 * #...O..#
 * #.#.O..#
 * #...O..#
 * #......#
 * ########
 * 
 * Move ^:
 * ########
 * #.@O.O.#
 * ##..O..#
 * #...O..#
 * #.#.O..#
 * #...O..#
 * #......#
 * ########
 * 
 * ........
 * The larger example has many more moves; after the robot has finished those moves, the warehouse would look like this:
 * 
 * ##########
 * #.O.O.OOO#
 * #........#
 * #OO......#
 * #OO@.....#
 * #O#.....O#
 * #O.....OO#
 * #O.....OO#
 * #OO....OO#
 * ##########
 * The lanternfish use their own custom Goods Positioning System (GPS for short) to track the locations of the boxes. The GPS coordinate of a box is equal to 100 times its distance from the top edge of the map plus its distance from the left edge of the map. (This process does not stop at wall tiles; measure all the way to the edges of the map.)
 * 
 * So, the box shown below has a distance of 1 from the top edge of the map and 4 from the left edge of the map, resulting in a GPS coordinate of 100 * 1 + 4 = 104.
 * 
 * #######
 * #...O..
 * #......
 * The lanternfish would like to know the sum of all boxes' GPS coordinates after the robot finishes moving. In the larger example, the sum of all boxes' GPS coordinates is 10092. In the smaller example, the sum is 2028.
 * 
 * Predict the motion of the robot and boxes in the warehouse. After the robot is finished moving, what is the sum of all boxes' GPS coordinates?
 * 
 * The first half of this puzzle is complete! It provides one gold star: *
 * 
 * --- Part Two ---
 * The lanternfish use your information to find a safe moment to swim in and turn off the malfunctioning robot! Just as they start preparing a festival in your honor, reports start coming in that a second warehouse's robot is also malfunctioning.
 * 
 * This warehouse's layout is surprisingly similar to the one you just helped. There is one key difference: everything except the robot is twice as wide! The robot's list of movements doesn't change.
 * 
 * To get the wider warehouse's map, start with your original map and, for each tile, make the following changes:
 * 
 * If the tile is #, the new map contains ## instead.
 * If the tile is O, the new map contains [] instead.
 * If the tile is ., the new map contains .. instead.
 * If the tile is @, the new map contains @. instead.
 * This will produce a new warehouse map which is twice as wide and with wide boxes that are represented by []. (The robot does not change size.)
 * 
 * The larger example from before would now look like this:
 * 
 * ####################
 * ##....[]....[]..[]##
 * ##............[]..##
 * ##..[][]....[]..[]##
 * ##....[]@.....[]..##
 * ##[]##....[]......##
 * ##[]....[]....[]..##
 * ##..[][]..[]..[][]##
 * ##........[]......##
 * ####################
 * Because boxes are now twice as wide but the robot is still the same size and speed, boxes can be aligned such that they directly push two other boxes at once. For example, consider this situation:
 * 
 * #######
 * #...#.#
 * #.....#
 * #..OO@#
 * #..O..#
 * #.....#
 * #######
 * 
 * <vv<<^^<<^^
 * After appropriately resizing this map, the robot would push around these boxes as follows:
 * 
 * Initial state:
 * ##############
 * ##......##..##
 * ##..........##
 * ##....[][]@.##
 * ##....[]....##
 * ##..........##
 * ##############
 * 
 * Move <:
 * ##############
 * ##......##..##
 * ##..........##
 * ##...[][]@..##
 * ##....[]....##
 * ##..........##
 * ##############
 * 
 * Move v:
 * ##############
 * ##......##..##
 * ##..........##
 * ##...[][]...##
 * ##....[].@..##
 * ##..........##
 * ##############
 * 
 * Move v:
 * ##############
 * ##......##..##
 * ##..........##
 * ##...[][]...##
 * ##....[]....##
 * ##.......@..##
 * ##############
 * 
 * Move <:
 * ##############
 * ##......##..##
 * ##..........##
 * ##...[][]...##
 * ##....[]....##
 * ##......@...##
 * ##############
 * 
 * Move <:
 * ##############
 * ##......##..##
 * ##..........##
 * ##...[][]...##
 * ##....[]....##
 * ##.....@....##
 * ##############
 * 
 * Move ^:
 * ##############
 * ##......##..##
 * ##...[][]...##
 * ##....[]....##
 * ##.....@....##
 * ##..........##
 * ##############
 * 
 * Move ^:
 * ##############
 * ##......##..##
 * ##...[][]...##
 * ##....[]....##
 * ##.....@....##
 * ##..........##
 * ##############
 * 
 * Move <:
 * ##############
 * ##......##..##
 * ##...[][]...##
 * ##....[]....##
 * ##....@.....##
 * ##..........##
 * ##############
 * 
 * Move <:
 * ##############
 * ##......##..##
 * ##...[][]...##
 * ##....[]....##
 * ##...@......##
 * ##..........##
 * ##############
 * 
 * Move ^:
 * ##############
 * ##......##..##
 * ##...[][]...##
 * ##...@[]....##
 * ##..........##
 * ##..........##
 * ##############
 * 
 * Move ^:
 * ##############
 * ##...[].##..##
 * ##...@.[]...##
 * ##....[]....##
 * ##..........##
 * ##..........##
 * ##############
 * This warehouse also uses GPS to locate the boxes. For these larger boxes, distances are measured from the edge of the map to the closest edge of the box in question. So, the box shown below has a distance of 1 from the top edge of the map and 5 from the left edge of the map, resulting in a GPS coordinate of 100 * 1 + 5 = 105.
 * 
 * ##########
 * ##...[]...
 * ##........
 * In the scaled-up version of the larger example from above, after the robot has finished all of its moves, the warehouse would look like this:
 * 
 * ####################
 * ##[].......[].[][]##
 * ##[]...........[].##
 * ##[]........[][][]##
 * ##[]......[]....[]##
 * ##..##......[]....##
 * ##..[]............##
 * ##..@......[].[][]##
 * ##......[][]..[]..##
 * ####################
 * The sum of these boxes' GPS coordinates is 9021.
 * 
 * Predict the motion of the robot and boxes in this new, scaled-up warehouse. What is the sum of all boxes' final GPS coordinates?
 * @template-implements Task<int, list<string>>
 */
return new class($input) implements Task {

    public TableStr $map;
    public array $commands;

    #[\Override] function __construct(string $input)
    {
        $map = [];
        $commands = '';
        $input = explode("\n", trim($input));
        $gapFound = false;
        foreach ($input as $i) {
            if (! trim($i)) {
                $gapFound = true;
                continue;
            }
            if (!$gapFound) {
                $map[] = str_split(trim($i));
                continue;
            }
            $commands .= trim($i);
        }
        $this->map = new TableStr($map);
        $this->commands = str_split($commands);
    }

    #[\Override] public function task1(): TaskOutput
    {
        $map = clone $this->map;
        $robot = null;
        for($y = 0; $y < $map->sizeY; $y++) {
            for($x = 0; $x < $map->sizeX; $x++) {
                if ($map->get($y, $x, '-') == '@') {
                    $robot = [$y, $x];
                    break 2;
                }
            }
        }

        // $GIF = new \Imagick();
        // $GIF->setFormat("gif");

        foreach ($this->commands as $id => $command) {
        //     $image = $map->print([
        //         '#' => function(\Imagick $i, int $x, int $y) {
        //             $draw = new \ImagickDraw();
        //             $draw->setFillColor(new \ImagickPixel('#FF0000'));
        //             $draw->rectangle($x * 9 + 1, $y * 9 + 1, ($x + 1) * 9 - 2, ($y + 1) * 9 - 2);
        //             $i->drawImage($draw);
        //          },
        //         '.' => null,
        //         'O' => function(\Imagick $i, int $x, int $y) {
        //             $draw = new \ImagickDraw();
        //             $draw->setFillColor(new \ImagickPixel('#00FF00'));
        //             $draw->rectangle($x * 9 + 1, $y * 9 + 1, ($x + 1) * 9 - 2, ($y + 1) * 9 - 2);
        //             $i->drawImage($draw);
        //          },
        //         '@' => function(\Imagick $i, int $x, int $y) {
        //             $draw = new \ImagickDraw();
        //             $draw->setFillColor(new \ImagickPixel('#0000FF'));
        //             $draw->rectangle($x * 9 + 1, $y * 9 + 1, ($x + 1) * 9 - 2, ($y + 1) * 9 - 2);
        //             $i->drawImage($draw);
        //          },
        //     ], 9); 
            
        //     $image->setImageDelay(2 * $id);
        //     $GIF->addImage($image);
           
            [$dy, $dx] = match ($command) {
                '>' => [0, 1],
                'v' => [1, 0],
                '<' => [0, -1],
                '^' => [-1, 0],
            };
            $movable = '@';
            $steps = 0;
            while(++$steps) {
                $next = $map->get($robot[0] + $dy * $steps, $robot[1] + $dx * $steps, '#');
                if ($next == '.') {
                    $map->set($robot[0] + $dy * $steps, $robot[1] + $dx * $steps, $movable);
                    $map->set($robot[0] + $dy, $robot[1] + $dx, '@');
                    $map->set($robot[0], $robot[1], '.');

                    $robot[0] += $dy;
                    $robot[1] += $dx;
                    break;
                }
                if ($next == 'O') {
                    $movable = 'O';
                    continue;
                }
                if ($next == '#') {
                    break;
                }
            }
        }

        // $GIF->writeImages("output/day15/map.gif", true);

        $score = 0;
        for($y = 0; $y < $map->sizeY; $y++) {
            for($x = 0; $x < $map->sizeX; $x++) {
                if ($map->get($y, $x, '#') == 'O') {
                    $score += ($y * 100) + $x;
                }
            }
        }
        return new TaskOutput($score);
    }


    #[\Override] public function task2(): TaskOutput
    {
        $map = clone $this->map;
        $newMap = [];
        $robot = null;
        for($y = 0; $y < $map->sizeY; $y++) {
            for($x = 0; $x < $map->sizeX; $x++) {
                if ($map->get($y, $x, '-') == '.') {
                    $newMap[$y][$x * 2] = '.';
                    $newMap[$y][$x * 2 + 1] = '.';
                }
                if ($map->get($y, $x, '-') == '#') {
                    $newMap[$y][$x * 2] = '#';
                    $newMap[$y][$x * 2 + 1] = '#';
                }
                if ($map->get($y, $x, '-') == 'O') {
                    $newMap[$y][$x * 2] = '[';
                    $newMap[$y][$x * 2 + 1] = ']';
                }
                if ($map->get($y, $x, '-') == '@') {
                    $robot = [$y, $x * 2];
                    $newMap[$y][$x * 2] = '@';
                    $newMap[$y][$x * 2 + 1] = '.';
                }
            }
        }
        $map = new TableStr($newMap);

        // $GIF = new \Imagick();
        // $GIF->setFormat("gif");

        foreach ($this->commands as $id => $command) {
            // $image = $map->print([
            //     '#' => function(\Imagick $i, int $x, int $y) {
            //         $draw = new \ImagickDraw();
            //         $draw->setFillColor(new \ImagickPixel('#FF0000'));
            //         $draw->rectangle($x * 9 + 1, $y * 9 + 1, ($x + 1) * 9 - 2, ($y + 1) * 9 - 2);
            //         $i->drawImage($draw);
            //      },
            //     '.' => null,
            //     '[' => function(\Imagick $i, int $x, int $y) {
            //         $draw = new \ImagickDraw();
            //         $draw->setFillColor(new \ImagickPixel('#00FF00'));
            //         $draw->rectangle($x * 9 + 1, $y * 9 + 1, ($x + 1) * 9, ($y + 1) * 9 - 2);
            //         $i->drawImage($draw);
            //      },
            //      ']' => function(\Imagick $i, int $x, int $y) {
            //         $draw = new \ImagickDraw();
            //         $draw->setFillColor(new \ImagickPixel('#00FF00'));
            //         $draw->rectangle($x * 9, $y * 9 + 1, ($x + 1) * 9 - 2, ($y + 1) * 9 - 2);
            //         $i->drawImage($draw);
            //      },
            //     '@' => function(\Imagick $i, int $x, int $y) {
            //         $draw = new \ImagickDraw();
            //         $draw->setFillColor(new \ImagickPixel('#0000FF'));
            //         $draw->rectangle($x * 9 + 1, $y * 9 + 1, ($x + 1) * 9 - 2, ($y + 1) * 9 - 2);
            //         $i->drawImage($draw);
            //      },
            // ], 9); 
            
            // $image->setImageDelay(20);
            // $GIF->addImage($image);
           
            [$dy, $dx] = match ($command) {
                '>' => [0, 1],
                'v' => [1, 0],
                '<' => [0, -1],
                '^' => [-1, 0],
            };
            $steps = 0;
            if (in_array($command, ["<", ">"])) {
                while(++$steps) {
                    $next = $map->get($robot[0] + $dy * $steps, $robot[1] + $dx * $steps, '#');
                    if ($next == '.') {
                        $newMap = clone $map;
                        for ($i = $steps; $i >= 0; $i--) {
                            $newMap->set($robot[0] + $dy * $i, $robot[1] + $dx * $i, $map->get($robot[0] + $dy * ($i - 1), $robot[1] + $dx * ($i - 1), '#'));
                        }
                        $newMap->set($robot[0], $robot[1], '.');  
                        $map = $newMap;                    
                        $robot[0] += $dy;
                        $robot[1] += $dx;
                        break;
                    }
                    if ($next == '[' || $next == "]") {
                        continue;
                    }
                    if ($next == '#') {
                        break;
                    }
                }
            } else {
                $tree = [[[...$robot, '@', $command, $id]]];
                while(++$steps) {
                    $canopy = end($tree);
                    $new = [];
                    foreach ($canopy as $i => $pos) {
                        $next = $map->get($pos[0] + $dy, $pos[1] + $dx, '#');  
                  
                        if ($next == '.') {
                            continue;
                        }
                        if ($next == '[') {
                            $new[] = [$pos[0] + $dy, $pos[1] + $dx, '['];
                            $new[] = [$pos[0] + $dy, $pos[1] + $dx + 1, ']'];
                            continue;
                        }
                        if ($next == "]") {
                            $new[] = [$pos[0] + $dy, $pos[1] + $dx, ']'];
                            $new[] = [$pos[0] + $dy, $pos[1] + $dx - 1, '['];
                            continue;
                        }
                        if ($next == '#') {
                            continue 3;
                        }
                    }
                    if (! $new) {
                        $newMap = clone $map;
                        foreach (array_reverse($tree) as $branch) {
                            foreach ($branch as $node) {
                                $newMap->set($node[0], $node[1], '.');
                                $newMap->set($node[0] + $dy, $node[1] + $dx, $node[2]);
                            }
                        }
                        $newMap->set($robot[0], $robot[1], '.');
                        $map = $newMap;                                         
                        $robot[0] += $dy;
                        $robot[1] += $dx;
                        break;
                    } else {
                        $tree[] = $new;

                    }
                }
            }
        }

        // $GIF->writeImages("output/day15/map-2.gif", true);

        $score = 0;
        for($y = 0; $y < $map->sizeY; $y++) {
            for($x = 0; $x < $map->sizeX; $x++) {
                if ($map->get($y, $x, '#') == '[') {
                    $score += ($y * 100) + $x;
                }
            }
        }
        return new TaskOutput($score);
    }
};