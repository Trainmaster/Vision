<?php
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
