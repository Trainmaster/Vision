<?php
declare(strict_types=1);

namespace Vision\File\Loader;

interface LoaderInterface
{
    /**
     * @param string $resource
     */
    public function load($resource);
}
