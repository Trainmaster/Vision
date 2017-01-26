<?php
declare(strict_types=1);

namespace Vision\DataStructures\Arrays;

use ArrayAccess;
use Countable;

class ArrayObject implements ArrayAccess, Countable
{
    /** @var array $data */
    protected $data = [];

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function exchangeArray(array $data)
    {
        $oldArray = $this->data;
        $this->data = $data;
        return $oldArray;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->data);
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        return $this->data;
    }

    /**
     * @param int|string $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * @param int|string $offset
     *
     * @return mixed
     */
    public function &offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * @param int|string $offset
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * @param int|string $offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    /**
     * @param int $mode
     *
     * @return int
     */
    public function count($mode = COUNT_NORMAL)
    {
        return count($this->data, $mode);
    }
}
