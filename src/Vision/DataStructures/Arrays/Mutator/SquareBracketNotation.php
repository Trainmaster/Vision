<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\DataStructures\Arrays\Mutator;

/**
 * SquareBracketNotation
 *
 * @author Frank Liepert
 */
class SquareBracketNotation
{
    /** @type array $data */
    protected $data = array();

    /**
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->data = $data;
    }

    /**
     * @api
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
    
    /**
     * @api
     *
     * @param array $data
     *
     * @return $this Provides a fluent interface.
     */
    public function exchangeArray(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return mixed
     */
    public function set($name, $value)
    {
        $name = $this->prepareName($name);

        $parts = explode('[', $name);
        $data =& $this->data;

        foreach ($parts as $part) {
            $part = rtrim($part, ']');

            if (!isset($data[$part])) {
                $data[$part] = array();
            }

            if (!is_array($data[$part])) {
                return $this;
            }

            $data =& $data[$part];
        }

        $data = $value;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function get($name)
    {
        $name = $this->prepareName($name);

        $parts = explode('[', $name);
        $data = $this->data;

        foreach ($parts as $part) {
            $part = rtrim($part, ']');
            if (isset($data[$part])) {
                $data = $data[$part];
            } else {
                return null;
            }
        }

        return $data;
    }

    /**
     * @internal
     *
     * @param string $name
     *
     * @return string
     */
    protected function prepareName($name)
    {
        $name = (string) $name;

        if (strpos($name, '[]') !== false) {
            $name = str_replace('[]', '', $name);
        }

        return $name;
    }
}
