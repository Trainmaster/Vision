<?php
declare(strict_types=1);

namespace Vision\DependencyInjection;

interface ContainerInterface
{
    /**
     * @param string $alias
     */
    public function get($alias);
}
