<?php

namespace Robchett\Aoc2024\Input;

readonly class PrinterRule {
    
    /** @param list<int> $requires */
    public function __construct(public array $requires) {
    }

    /** @param list<int> $previousPages */
    public function validate(array $previousPages): array {
        return array_intersect($previousPages, $this->requires);
    }
}