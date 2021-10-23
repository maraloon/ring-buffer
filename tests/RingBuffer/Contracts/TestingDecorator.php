<?php declare(strict_types=1);

namespace Tests\RingBuffer\Contracts;

use Tests\RingBuffer\Math\Ratio;

interface TestingDecorator {

    /** allow writing several items at once */
    function writeStack(array $items);

    //    /** @return RingBuffer origin object */
    //    function object(): RingBuffer;

    /** todo   */
    function writeAndRead(array $items, Ratio $writeToReadRatio): array;
}