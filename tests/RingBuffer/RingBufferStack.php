<?php declare(strict_types=1);

namespace Tests\RingBuffer;

use App\RingBuffer;
use ReflectionProperty;

final class RingBufferStack /*implements Contracts\TestingDecorator*/
{

    private ReflectionProperty $stackProperty;
    function __construct(private RingBuffer $ringBuffer) {
        $this->stackProperty = new ReflectionProperty(RingBuffer::class, 'stack');
        $this->stackProperty->setAccessible(true);
    }

    function stack(): array {
        return array_filter(
            $this->stackProperty->getValue($this->ringBuffer)
        );
    }
}