<?php

namespace App\RingBuffer;

use App\Contracts\DataStructure\Buffer;

class RingBuffer implements Buffer {
    protected array $stack;
    protected int $n;

    function __construct(int $itemsNumber) {
        $this->n = $itemsNumber;
        $this->stack = array_fill(0, $itemsNumber, null);
    }

    function push(int $item): Buffer {
        $key = key($this->stack);

        if ($key > ($this->n-1))
            reset($this->stack);

        $this->stack[$key] = $item;
        next($this->stack);

        return $this;
    }

    function shift(): int|null {
        return array_shift($this->stack);
    }
}
