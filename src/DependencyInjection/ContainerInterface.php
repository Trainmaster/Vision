<?php
declare(strict_types = 1);

namespace Vision\DependencyInjection;

interface ContainerInterface
{
    public function get(string $alias);
}
