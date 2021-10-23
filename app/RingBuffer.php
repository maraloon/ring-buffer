<?php declare(strict_types=1);

namespace App;

use App\Contracts\DataStructure\Buffer;
use InvalidArgumentException;
use UnderflowException;

class RingBuffer implements Buffer {
    protected array $stack;
    protected int $readPointer;

    function __construct(int $size) {
        if($size < 1) throw new InvalidArgumentException();

        $this->stack = array_fill(0, $size, null);
        $this->readPointer = array_key_last($this->stack);
    }

    function write($item): void {
        $this->stack[key($this->stack)] = $item;

        if(next($this->stack) === false)
            reset($this->stack);
    }

    // todo remove to another class (etc. RingBufferReader)
    function read(): mixed {
        $r = $this->readPointer;
        $w = key($this->stack);

        //        if($w === 0 && $r === count($this->stack) - 1) {
        //            throw new UnderflowException('1Reading is faster then buffer writing');
        //        }

        if($r < $w) {
            throw new UnderflowException('Reading is faster then buffer writing');
        }

        if(++$this->readPointer > array_key_last($this->stack))
            $this->readPointer = 0;

        return $this->stack[$this->readPointer];
    }
}
