<?php

namespace Robchett\Aoc2024\Input;

/**  */
class Words implements \Iterator, \ArrayAccess {

    protected int $index;
    public private(set) array $words;
    

    public function __construct( array $words ) {
        $this->index = 0;
        $this->words = array_values($words);
    }

    public function current(): Word {
        return new Word($this->words[$this->index]);
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
        return isset($this->words[$this->index]);
    }

    public function offsetExists(mixed $offset): bool {
        return isset($this->words[$offset]);
    }
    public function offsetGet(mixed $offset): Word {
        return new Word($this->words[$offset]);
    }
    public function offsetSet(mixed $offset, mixed $value): void {
        throw new \Exception("Words is a readonly iterator");
    }
    public function offsetUnset(mixed $offset): void     {
        throw new \Exception("Words is a readonly iterator");
    }
}