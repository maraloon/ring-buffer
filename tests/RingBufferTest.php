<?php

namespace Tests;

use App\Contracts\TestWrappers\IsEqual;
use App\RingBuffer\RingBuffer;
use DomainException;

class RingBufferTest {
    function testRingBuffer() {
        $rb = $this->ringBufferTester();
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

    function ringBufferTester(): RingBuffer {
        return new class extends RingBuffer implements IsEqual {
            function is(array $expected): void {
                if ($this->stack !== $expected) {
                    throw new DomainException("Test failure: expected $expected but stack is $this->stack");
                }
            }
        };
    }

}