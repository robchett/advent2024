<?php

namespace Robchett\Aoc2024\Input;

class PrinterCommand {

    protected int $index = 0;
    
    /** @param list<int> $command */
    public function __construct(public protected(set) array $command) {
    }

    public function shift(): int|null
    {
        if (! isset($this->command[$this->index])) {
            return null;
        }
        return $this->command[$this->index++];
    }

    public function reset() 
    {
        $this->index = 0;
    }

    public function middle(): int
    {
        return $this->command[floor(count($this->command) / 2)];
    }
}