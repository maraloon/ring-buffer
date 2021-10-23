<?php declare(strict_types=1);

namespace Tests\RingBuffer\Math;

final class Ratio {
    function __construct(
        protected int|float $one,
        protected int|float $another) {
    }

    function one(): float|int { return $this->one; }
    function another(): float|int { return $this->another; }
}