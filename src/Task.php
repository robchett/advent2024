<?php

namespace Robchett\Aoc2024;

/**
 * @template Toutput of scalar
 * @template Tinput
 */
interface Task
{

    function __construct(string $input);

    /**
     * @param Tinput $input
     * @return TaskOutput<Toutput>
     */
    public function task1(): TaskOutput;

    /**
     * @param Tinput $input
     * @return TaskOutput<Toutput>
     */
    public function task2(): TaskOutput;

}