<?php

namespace Robchett\Aoc2024\Input;

readonly class Line {
    

    public function __construct( public string $line ) {
    }

    public function words(string $seperator = " "): Words {
        return new Words(array_values(array_filter(explode($seperator, $this->line))));
    }
}