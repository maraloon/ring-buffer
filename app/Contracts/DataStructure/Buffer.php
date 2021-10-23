<?php

namespace App\Contracts\DataStructure;

interface Buffer {
    /* push item into stack */
    function push($item): void;

    /* get first inserted item */
    function shift(): int|null;
}