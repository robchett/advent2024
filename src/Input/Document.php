<?php

namespace Robchett\Aoc2024\Input;

readonly class Document {
    
    public function __construct( public string $content) {
    }

    public function lines(): Lines {
        return new Lines(explode("\n", $this->content));
    }
}