<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\DataStructures\Arrays\Mutator;

use Vision\DataStructures\Arrays\ArrayObject;

class SquareBracketNotation extends ArrayObject
{
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
                $data[$part] = [];
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
