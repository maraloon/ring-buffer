<?php

namespace App\Contracts\TestWrappers;

interface IsEqual {
    /** @throws DomainException */
    function is(array $expected): void;
}