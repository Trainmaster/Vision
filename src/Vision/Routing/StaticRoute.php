<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Routing;

class StaticRoute extends AbstractCompiledRoute
{
    /** @var null|string $path */
    protected $path;

    /**
     * @param string $path
     * @param string $class
     * @param string $method
     */
    public function __construct($path, $class, $method)
    {
        $this->path = trim($path);

        parent::setClass($class);

        if (isset($method)) {
            parent::setMethod($method);
        }
    }

    /**
     * @api
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
