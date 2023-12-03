<?php

namespace Robchett\Aoc2024;

use Robchett\Aoc2024\Structures\Day2\Draw;
use Robchett\Aoc2024\Structures\Day2\Game;

/**
 * @template-implements Task<int, list<string>>
 */
return new class implements Task {

    #[\Override] function parseInput(string $input): mixed
    {
        return explode("\n", $input);
    }

    #[\Override] public function task1(mixed $input): TaskOutput
    {
        return new TaskOutput(0);
    }

    #[\Override] public function task2(mixed $input): TaskOutput
    {
        return new TaskOutput(0);
    }
};