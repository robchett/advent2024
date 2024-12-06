<?php

namespace Robchett\Aoc2024\Input;

class Map implements \Iterator, \ArrayAccess {

    protected int $index;
    public protected(Set) int $sizeY;
    public protected(Set) int $sizeX;

    public function __construct(public protected(set) array $rows)  
    {
        $this->sizeY = count($rows);
        $this->sizeX = count($rows[0]);
    }

    public static function parse(string $content): static {
        $lines = explode("\n", $content);
        return new static(array_map(fn(string $s) => array_map(fn(string $s) => (int) $s, array_values(array_filter(explode(' ', $s), fn(string $s) => $s !== ''))), $lines));
    }

    public function pivot(): Table {
        $rows = [];
        foreach ($this->rows as $row) {
            foreach ($row as $key => $value) {
                $rows[$key][] = $value;
            }
        }
        return new static($rows);
    }

    public function current(): array {
        return $this->rows[$this->index];
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
        return isset($this->rows[$this->index]);
    }

    public function offsetExists(mixed $offset): bool {
        return isset($this->rows[$offset]);
    }
    public function offsetGet(mixed $offset): array {
        return $this->rows[$offset];
    }
    public function offsetSet(mixed $offset, mixed $value): void {
        throw new \Exception("Table is a readonly iterator");
    }
    public function offsetUnset(mixed $offset): void     {
        throw new \Exception("Table is a readonly iterator");
    }
}