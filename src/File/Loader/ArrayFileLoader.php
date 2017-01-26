<?php
namespace Vision\File\Loader;

class ArrayFileLoader implements LoaderInterface
{
    /**
     * @param string $file
     *
     * @return array
     */
    public function load($file)
    {
        if (!is_readable($file)) {
            return [];
        }

        $data = include $file;

        return is_array($data) ? $data : [];
    }
}
