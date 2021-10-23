<?php declare(strict_types=1);

namespace Tests\RingBuffer;

use App\RingBuffer;
use Tests\RingBuffer\Math\Ratio;

final class TestingDecorator implements Contracts\TestingDecorator {

    private RingBuffer $ringBuffer;

    function __construct(int $size) {
        $this->ringBuffer = new RingBuffer($size);
    }


    function writeStack(array $items): void {
        foreach($items as $item) {
            $this->ringBuffer->write($item);
        }
    }

    function object(): RingBuffer {
        return $this->ringBuffer;
    }

    function stack(): array {
        $stackProperty = new \ReflectionProperty(RingBuffer::class, 'stack');
        $stackProperty->setAccessible(true);

        return array_filter(
            $stackProperty->getValue($this->ringBuffer)
        );
    }

    function writeAndRead(array $items, Ratio $writeToReadRatio): array {
        $tickWrite = fn($i) => ($i + 1) % $writeToReadRatio->one() === 0;
        $tickRead = fn($i) => ($i + 1) % $writeToReadRatio->another() === 0;

        for($i = 0; $i <= array_key_last($items); $i++) {
            if($tickWrite($i))
                $this->ringBuffer->write($items[$i]);

            if($tickRead($i))
                $readed[] = $this->ringBuffer->read();

        }

        return $readed;
    }
}