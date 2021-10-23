<?php declare(strict_types=1);

namespace Tests\RingBuffer;

use App\RingBuffer;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use UnderflowException;

final class Test extends TestCase {
    function testInvalidBufferSize(): void {
        $this->expectException(InvalidArgumentException::class);
        new RingBuffer(-5);
    }

    function testCircleRewritingProcess(): void {
        $ring = new RingBuffer(3);
        foreach(['a', 'b', 'c', 'x', 'y'] as $item) {
            $ring->write($item);
        }

        $this->assertEquals(['x', 'y', 'c'], $this->ringBufferStackValue($ring));
    }

    function testReadingProcess(): void {
        $ring = new RingBuffer(2);

        $ring->write('a');
        $ring->write('b');
        $read[] = $ring->read();
        $ring->write('x');
        $ring->write('y');
        $read[] = $ring->read();

        $this->assertEquals(['a', 'y'], $read);
    }

    function testReadingUnderflow(): void {
        $ring = new RingBuffer(2);
        $ring->write('a');
        $r = $ring->read();

        //        $this->expectException(UnderflowException::class);
        $d = $ring->read();
        $r === $d;

    }

    function testReadingUnderflow2(): void {
        $ring = new RingBuffer(3);
        $ring->write(1);
        $ring->write(2);
        $ring->write(3);
        $read[] = $ring->read();
        $ring->write(4);
        $ring->write(5);
        $read[] = $ring->read();

        $this->expectException(UnderflowException::class);
        // if we read, it'll be [1,5,3]. It's wrong to read older data
        $read[] = $ring->read();

        $read;
    }

    protected function ringBufferTestingDecorator(int $size): Contracts\TestingDecorator {
        return new TestingDecorator($size);
    }

    protected function ringBufferStackValue(RingBuffer $ringBuffer): array {
        $stackProperty = new \ReflectionProperty(RingBuffer::class, 'stack');
        $stackProperty->setAccessible(true);

        return array_filter(
            $stackProperty->getValue($ringBuffer)
        );
    }

    // todo проверить: new RingBuffer, read()

}