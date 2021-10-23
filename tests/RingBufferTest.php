<?php declare(strict_types=1);

namespace Tests;

use App\RingBuffer\RingBuffer;
use PHPUnit\Framework\TestCase;

final class RingBufferTest extends TestCase {
    function testRingBuffer(): void {
        $rb = new RingBuffer(5);
        $this->assertEmpty($rb->stack());

        $rb->push(1);
        $this->assertEquals([1], $rb->stack());

        $rb
            ->push(2)
            ->push(3)
            ->push(4)
            ->push(5);
        $this->assertEquals([1, 2, 3, 4, 5], $rb->stack());

        $rb->push(6);
        $this->assertEquals([6, 2, 3, 4, 5], $rb->stack());

        $rb->push(7);
        $this->assertEquals([6, 7, 3, 4, 5], $rb->stack());

        $rb->shift();
        $this->assertEquals([7, 3, 4, 5], $rb->stack());

        $rb->shift();
        $this->assertEquals([3, 4, 5], $rb->stack());

        $rb->shift();
        $rb->shift();
        $rb->shift();
        $this->assertEmpty($rb->stack());

//    $rb->shift(); ERROR on null
    }
}