<?php

namespace Robchett\Aoc2024\Input;

readonly class PrinterRules implements \ArrayAccess {
    
    /** @param array<int, PrinterRule> $rules */
    public function __construct( public array $rules) {
    }

    public function offsetExists(mixed $offset): bool {
        return isset($this->rules[$offset]);
    }
    public function offsetGet(mixed $offset): ?PrinterRule {
        return $this->rules[$offset];
    }
    public function offsetSet(mixed $offset, mixed $value): void {
        throw new \Exception("PrinterRules is readonly");
    }
    public function offsetUnset(mixed $offset): void     {
        throw new \Exception("PrinterRules is readonly");
    }
}