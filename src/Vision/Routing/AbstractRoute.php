<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Routing;

abstract class AbstractRoute
{
    /** @var string $httpMethod */
    protected $httpMethod;

    /** @var array $defaults */
    protected $defaults = [];

    /** @var array $requirements */
    protected $requirements = [];

    /**
     * @api
     *
     * @param array $defaults
     *
     * @return $this Provides a fluent interface.
     */
    public function setDefaults(array $defaults)
    {
        $this->defaults = $defaults;
        return $this;
    }

    /**
     * @api
     *
     * @return array
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * @api
     *
     * @param array $requirements
     *
     * @return $this Provides a fluent interface.
     */
    public function setRequirements(array $requirements)
    {
        $this->requirements = $requirements;
        return $this;
    }

    /**
     * @api
     *
     * @return array
     */
    public function getRequirements()
    {
        return $this->requirements;
    }

    /**
     * @api
     *
     * @param string $httpMethod
     *
     * @return $this Provides a fluent interface.
     */
    public function setHttpMethod($httpMethod)
    {
        $this->httpMethod = $httpMethod;
        return $this;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }
}
