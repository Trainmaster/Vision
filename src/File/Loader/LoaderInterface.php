<?php

declare(strict_types=1);

namespace Vision\File\Loader;

interface LoaderInterface
{
    /**
     * @param string $resource
     * @return mixed
     */
    public function load($resource);
}
