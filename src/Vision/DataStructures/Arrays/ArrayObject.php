<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\DataStructures\Arrays;

use ArrayAccess;

/**
 * ArrayObject
 *
 * @author Frank Liepert
 */
class ArrayObject implements ArrayAccess
{
    /** @type array $data */
    protected $data = array();

    /**
     * @param array $data
     *
     * @return void
     */
    public function __construct(array $data = array())
    {
        $this->data = $data;
    }

    /**
     * @param array $data
     *
     * @return ArrayProxyObject Provides a fluent interface.
     */
    public function exchangeArray(array $data)
    {
        $this->data = $data;
        return $this;
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
}