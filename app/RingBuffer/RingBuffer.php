<?php

namespace App\RingBuffer;

use App\Contracts\DataStructure\Buffer;

class RingBuffer implements Buffer {
    protected array $stack;

    function __construct(int $itemsNumber) {
        $this->stack = array_fill(0, $itemsNumber, null);
    }

    function push(int $item): Buffer {
        $this->stack[key($this->stack)] = $item;

        if (next($this->stack) === false)
            reset($this->stack);

        return $this;
    }

    function shift(): int|null {
        return array_shift($this->stack);
    }

    function stack(): array {
        return array_filter($this->stack);
    }
}
