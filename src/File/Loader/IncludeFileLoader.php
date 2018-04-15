<?php

declare(strict_types=1);

namespace Vision\File\Loader;

class IncludeFileLoader implements LoaderInterface
{
    /**
     * @param string $file
     * @throws \Exception If file is not a file
     * @throws \Exception If file could not be read from
     * @return mixed
     */
    public function load($file)
    {
        if (!is_file($file)) {
            throw new \Exception(sprintf('The provided file "%s" is not a file.', $file));
        }

        if (!is_readable($file)) {
            throw new \Exception(sprintf('Could not read from file "%s".', $file));
        }

        return include $file;
    }
}
