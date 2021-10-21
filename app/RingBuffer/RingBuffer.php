<?php

namespace App\RingBuffer;

use App\Contracts\DataStructure\Buffer;

class RingBuffer implements Buffer {
    protected array $stack = [];
    protected int $n;

    function __construct(int $itemsNumber) {
        $this->n = $itemsNumber;
    }

    function push(int $item): Buffer {
        if (key($this->stack) > ($this->n-1)) {
            reset($this->stack);
        }

        $this->stack[key($this->stack)] = $item;
        next($this->stack);

        return $this;
    }

    function shift(): int|null {
        array_shift($this->stack);
    }
}
