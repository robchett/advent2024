<?php

namespace Robchett\Aoc2024;

/**
 * @template Toutput of scalar
 * @template Tinput
 */
interface Task
{
    /**
     * @param string $input
     * @return Tinput
     */
    function parseInput(string $input): mixed;

    /**
     * @param Tinput $input
     * @return TaskOutput<Toutput>
     */
    public function task1(mixed $input): TaskOutput;

    /**
     * @param Tinput $input
     * @return TaskOutput<Toutput>
     */
    public function task2(mixed $input): TaskOutput;

}