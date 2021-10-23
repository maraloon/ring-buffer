<?php

namespace App\Contracts\DataStructure;

interface Buffer {
    function write($item): void;

    // todo incapsulate to reading interface
    function read(): mixed;
}