<?php
declare(strict_types = 1);

namespace Vision\DataStructures\Arrays\Mutator;

use Vision\DataStructures\Arrays\ArrayObject;

class SquareBracketNotation extends ArrayObject
{
    public function set(string $name, $value): SquareBracketNotation
    {
        $data =& $this->data;

        foreach ($this->extractPartsFromName($name) as $part) {
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

    public function get(string $name)
    {
        $data = $this->data;

        foreach ($this->extractPartsFromName($name) as $part) {
            $part = rtrim($part, ']');
            if (isset($data[$part])) {
                $data = $data[$part];
            } else {
                return null;
            }
        }

        return $data;
    }

    private function extractPartsFromName(string $name): array
    {
        if (strpos($name, '[]') !== false) {
            $name = str_replace('[]', '', $name);
        }

        return explode('[', $name);
    }
}
