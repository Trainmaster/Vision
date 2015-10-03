<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Routing;

class RegexRoute extends AbstractCompiledRoute
{
    /** @var null|string $regex */
    protected $regex;

    /**
     * @param string $regex
     * @param string $class
     * @param string|null $method
     */
    public function __construct($regex, $class, $method = null)
    {
        $this->regex = trim($regex);

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
    public function getRegex()
    {
        return $this->regex;
    }
}
