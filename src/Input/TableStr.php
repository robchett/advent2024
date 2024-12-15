<?php

namespace Robchett\Aoc2024\Input;

class TableStr implements \Iterator, \ArrayAccess {

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
        return new static(array_map(fn(string $s) => str_split(trim($s)), $lines));
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

    public function get(int $y, int $x, string $default): string {
        if (
            $y >= $this->sizeY ||
            $y < 0 ||
            $x >= $this->sizeX ||
            $x < 0
        ) {
            return $default;
        }
        return $this->rows[$y][$x];
    }

    public function set(int $y, int $x, string $value): void {
        if (
            $y >= $this->sizeY ||
            $y < 0 ||
            $x >= $this->sizeX ||
            $x < 0
        ) {
            throw new \Exception('OOB');
        }
        $this->rows[$y][$x] = $value;
    }

    public function print(array $translations, int $glyphSize = 1): \Imagick 
    {
        $image = new \Imagick();
        $image->newImage($this->sizeX * $glyphSize, $this->sizeY * $glyphSize, new \ImagickPixel('#FFFFFF'), 'png');   
        for($y = 0; $y < $this->sizeY; $y++) {
            for($x = 0; $x < $this->sizeX; $x++) {
                $val = $this->get($y, $x, '');
                $draw = $translations[$val] ?? null;
                if ($draw) {
                    $draw($image, $x, $y);
                }
            }
        }
        return $image;
    }  
    public function current(): array {
        return $this->rows[$this->index];
    }
    public function key(): string {
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