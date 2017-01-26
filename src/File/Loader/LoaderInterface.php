<?php
namespace Vision\File\Loader;

interface LoaderInterface
{
    /**
     * @param string $resource
     */
    public function load($resource);
}
