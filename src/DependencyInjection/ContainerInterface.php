<?php
declare(strict_types=1);

namespace Vision\DependencyInjection;

/**
 * ContainerInterface
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
interface ContainerInterface
{
    /**
     * @param string $alias
     */
    public function get($alias);
}
