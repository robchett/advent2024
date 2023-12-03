<?php

namespace Robchett\Aoc2024\Input;

/**  */
class Lines implements \Iterator {

    protected int $index;
    public private(set) array $lines;
    

    public function __construct( array $lines ) {
        $this->index = 0;
        $this->lines = array_values($lines);
    }

    public function current(): Line {
        return new Line($this->lines[$this->index]);
    }
    public function key(): int {
        return $this->index;
    }
    public function next(): void {
        $this->index++;
    }
    public function rewind(): void {
        $this->index = 0;
    }
    public function valid(): bool {
        return isset($this->lines[$this->index]);
    }
}