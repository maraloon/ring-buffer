<?php

function testRingBuffer() {
    $rb = new RingBufferTester(5);
    $rb->is([]);

    $rb->push(1);
    $rb->is([1]);

    $rb
        ->push(2)
        ->push(3)
        ->push(4)
        ->push(5);
    $rb->is([1, 2, 3, 4, 5]);

    $rb->push(6);
    $rb->is([6, 2, 3, 4, 5]);
    $rb->push(7);
    $rb->is([6, 7, 3, 4, 5]);

    $rb->shift();
    $rb->is([7, 3, 4, 5]);
    $rb->shift();
    $rb->is([3, 4, 5]);

    $rb->shift();
    $rb->shift();
    $rb->shift();
    $rb->is([]);

//    $rb->shift(); ERROR on null

}

interface Buffer {
    /* push item into stack */
    function push(int $item): Buffer;

    /* get first inserted item */
    function shift(): int|null;
}

interface BufferTester {
    /** @throws DomainException */
    function is(array $expectedBuffer): void;
}

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

class RingBufferTester extends RingBuffer implements BufferTester {
    function is(array $expectedBuffer): void {
        if ($this->stack !== $expectedBuffer) {
            throw new DomainException("Test failure: expected $expectedBuffer but stack is $this->stack");
        }
    }
}
