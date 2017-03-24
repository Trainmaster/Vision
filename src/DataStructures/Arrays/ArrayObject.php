<?php
declare(strict_types = 1);

namespace Vision\DataStructures\Arrays;

use ArrayAccess;
use Countable;

class ArrayObject implements ArrayAccess, Countable
{
    protected $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function exchangeArray(array $data): array
    {
        $oldArray = $this->data;
        $this->data = $data;
        return $oldArray;
    }

    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    public function getArrayCopy(): array
    {
        return $this->data;
    }

    /**
     * @param int|string $offset
     */
    public function offsetExists($offset): bool
    {
        return isset($this->data[$offset]);
    }

    /**
     * @param int|string $offset
     */
    public function &offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * @param int|string $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * @param int|string $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function count(int $mode = COUNT_NORMAL): int
    {
        return count($this->data, $mode);
    }
}
