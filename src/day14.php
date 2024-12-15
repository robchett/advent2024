<?php

namespace Robchett\Aoc2024;

/**
 * --- Day 14: Restroom Redoubt ---
 * One of The Historians needs to use the bathroom; fortunately, you know there's a bathroom near an unvisited location on their list, and so you're all quickly teleported directly to the lobby of Easter Bunny Headquarters.
 * 
 * Unfortunately, EBHQ seems to have "improved" bathroom security again after your last visit. The area outside the bathroom is swarming with robots!
 * 
 * To get The Historian safely to the bathroom, you'll need a way to predict where the robots will be in the future. Fortunately, they all seem to be moving on the tile floor in predictable straight lines.
 * 
 * You make a list (your puzzle input) of all of the robots' current positions (p) and velocities (v), one robot per line. For example:
 * 
 * p=0,4 v=3,-3
 * p=6,3 v=-1,-3
 * p=10,3 v=-1,2
 * p=2,0 v=2,-1
 * p=0,0 v=1,3
 * p=3,0 v=-2,-2
 * p=7,6 v=-1,-3
 * p=3,0 v=-1,-2
 * p=9,3 v=2,3
 * p=7,3 v=-1,2
 * p=2,4 v=2,-3
 * p=9,5 v=-3,-3
 * Each robot's position is given as p=x,y where x represents the number of tiles the robot is from the left wall and y represents the number of tiles from the top wall (when viewed from above). So, a position of p=0,0 means the robot is all the way in the top-left corner.
 * 
 * Each robot's velocity is given as v=x,y where x and y are given in tiles per second. Positive x means the robot is moving to the right, and positive y means the robot is moving down. So, a velocity of v=1,-2 means that each second, the robot moves 1 tile to the right and 2 tiles up.
 * 
 * The robots outside the actual bathroom are in a space which is 101 tiles wide and 103 tiles tall (when viewed from above). However, in this example, the robots are in a space which is only 11 tiles wide and 7 tiles tall.
 * 
 * The robots are good at navigating over/under each other (due to a combination of springs, extendable legs, and quadcopters), so they can share the same tile and don't interact with each other. Visually, the number of robots on each tile in this example looks like this:
 * 
 * 1.12.......
 * ...........
 * ...........
 * ......11.11
 * 1.1........
 * .........1.
 * .......1...
 * These robots have a unique feature for maximum bathroom security: they can teleport. When a robot would run into an edge of the space they're in, they instead teleport to the other side, effectively wrapping around the edges. Here is what robot p=2,4 v=2,-3 does for the first few seconds:
 * 
 * Initial state:
 * ...........
 * ...........
 * ...........
 * ...........
 * ..1........
 * ...........
 * ...........
 * 
 * After 1 second:
 * ...........
 * ....1......
 * ...........
 * ...........
 * ...........
 * ...........
 * ...........
 * 
 * After 2 seconds:
 * ...........
 * ...........
 * ...........
 * ...........
 * ...........
 * ......1....
 * ...........
 * 
 * After 3 seconds:
 * ...........
 * ...........
 * ........1..
 * ...........
 * ...........
 * ...........
 * ...........
 * 
 * After 4 seconds:
 * ...........
 * ...........
 * ...........
 * ...........
 * ...........
 * ...........
 * ..........1
 * 
 * After 5 seconds:
 * ...........
 * ...........
 * ...........
 * .1.........
 * ...........
 * ...........
 * ...........
 * The Historian can't wait much longer, so you don't have to simulate the robots for very long. Where will the robots be after 100 seconds?
 * 
 * In the above example, the number of robots on each tile after 100 seconds has elapsed looks like this:
 * 
 * ......2..1.
 * ...........
 * 1..........
 * .11........
 * .....1.....
 * ...12......
 * .1....1....
 * To determine the safest area, count the number of robots in each quadrant after 100 seconds. Robots that are exactly in the middle (horizontally or vertically) don't count as being in any quadrant, so the only relevant robots are:
 * 
 * ..... 2..1.
 * ..... .....
 * 1.... .....
 *            
 * ..... .....
 * ...12 .....
 * .1... 1....
 * In this example, the quadrants contain 1, 3, 4, and 1 robot. Multiplying these together gives a total safety factor of 12.
 * 
 * Predict the motion of the robots in your list within a space which is 101 tiles wide and 103 tiles tall. What will the safety factor be after exactly 100 seconds have elapsed?
 * 
 * --- Part Two ---
 * During the bathroom break, someone notices that these robots seem awfully similar to ones built and used at the North Pole. If they're the same type of robots, they should have a hard-coded Easter egg: very rarely, most of the robots should arrange themselves into a picture of a Christmas tree.
 * 
 * What is the fewest number of seconds that must elapse for the robots to display the Easter egg?
 * @template-implements Task<int, list<string>>
 */
return new class($input) implements Task {

    protected array $robots;

    #[\Override] function __construct(string $input)
    {
        $lines = explode("\n", trim($input));
        $robots = [];
        foreach ($lines as $line) {
            preg_match('/p=(-?\d+),(-?\d+) v=(-?\d+),(-?\d+)/', $line, $m);

            $robots[] = [
                'p' => [$m[1], $m[2]],
                'v' => [$m[3], $m[4]],
            ];
        }
        $this->robots = $robots;
    }

    #[\Override] public function task1(): TaskOutput
    {
        $finalPositions = [];
        [$x, $y] = count($this->robots) < 15 ? [11,7] : [101, 103]; 
        $steps = 100;

        foreach ($this->robots as ['p' => $p, 'v' => $v]) {
            $finalPosition[] = [
                (int) gmp_mod($p[0] + ($v[0] * $steps), $x),
                (int) gmp_mod($p[1] + ($v[1] * $steps), $y),
            ];
        } 
        $tl = $tr = $bl = $br = 0;   
        $l = (int) ($x / 2);
        $t = (int) ($y / 2);

        foreach ($finalPosition as [$fx, $fy]) {
            if ($fx < $l && $fy < $t) {
                $tl++;
            }
            if ($fx > $l && $fy < $t) {
                $tr++;
            }
            if ($fx < $l && $fy > $t) {
                $bl++;
            }
            if ($fx > $l && $fy > $t) {
                $br++;
            }
        }    
        return new TaskOutput($tl * $tr * $bl * $br);
    }

    #[\Override] public function task2(): TaskOutput
    {
        $finalPositions = [];
        [$x, $y] = count($this->robots) < 15 ? [11,7] : [101, 103]; 

        for($steps = 1; $steps < 10000; $steps++) {
            $image = new \Imagick();
            $image->newImage($x, $y, new \ImagickPixel('#FFFFFF'), 'png');   
            $draw = new \ImagickDraw();
            $draw->setFillColor(new \ImagickPixel('#000000'));
            foreach ($this->robots as ['p' => $p, 'v' => $v]) {
                $rx = (int) gmp_mod($p[0] + ($v[0] * $steps), $x);
                $ry = (int) gmp_mod($p[1] + ($v[1] * $steps), $y);
                $draw->rectangle(
                    $rx,
                    $ry, 
                    $rx + 1, 
                    $ry + 1
                );
            } 

            $image->drawImage($draw);
            $image->setImageFormat('png');
            $image->writeImage("output/$steps.png");
        }   
        return new TaskOutput(0);

    }
};