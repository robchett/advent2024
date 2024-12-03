<?php

namespace Robchett\Aoc2024;

/**
 * @template-implements Task<int, list<string>>
 */
return new class($input) implements Task {

    #[\Override] function __construct(string $input)
    {
    }

    #[\Override] public function task1(): TaskOutput
    {
        return new TaskOutput(0);
    }

    #[\Override] public function task2(): TaskOutput
    {
        return new TaskOutput(0);
    }
};