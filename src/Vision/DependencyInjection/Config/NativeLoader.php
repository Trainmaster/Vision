<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\DependencyInjection\Config;

use Vision\DependencyInjection as DI;
use Vision\File\Loader\ScopeFileLoader;

class NativeLoader extends ScopeFileLoader
{
    /** @var string $scopeName */
    protected $scopeName = 'container';

    /**
     * @param DI\Container $container
     */
    public function __construct(DI\Container $container)
    {
        $this->scope = $container;
    }
}
