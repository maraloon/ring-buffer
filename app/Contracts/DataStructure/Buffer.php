<?php

namespace App\Contracts\DataStructure;

interface Buffer {
    /* push item into stack */
    function push(int $item): Buffer;

    /* get first inserted item */
    function shift(): int|null;
}