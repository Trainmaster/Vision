<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Routing;

/**
 * RouteCompiler
 *
 * @author Frank Liepert
 */
class RouteCompiler
{
    /** @type string $requiredStartingChar */
    protected $requiredStartingChar = '{';

    /** @type string $requiredEndingChar */
    protected $requiredEndingChar = '}';

    /** @type string $optionalStartingChar */
    protected $optionalStartingChar = '<';

    /** @type string $optionalEndingChar */
    protected $optionalEndingChar = '>';

    /** @type string $defaultNamedGroupPattern */
    protected $defaultNamedGroupPattern = '[\w.~-]+';

    /**
     * @api
     *
     * @param string $pattern
     *
     * @return Router Provides a fluent interface.
     */
    public function setdefaultNamedGroupPattern($pattern)
    {
        $this->defaultNamedGroupPattern = $pattern;
        return $this;
    }

    /**
     * @api
     *
     * @param Route $route
     *
     * @return CompiledRoute
     */
    public function compile(Route $route)
    {
        $path = $route->getPath();
        $controller = $route->getController();
        $defaults = $route->getDefaults();
        $requirements = $route->getRequirements();
        $httpMethod = $route->getHttpMethod();

        $reqRegex = $this->createRequiredRegex();
        $optRegex = $this->createOptionalRegex();

        preg_match_all($reqRegex, $path, $req, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);
        preg_match_all($optRegex, $path, $opt, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);

        $matches = array_merge($req, $opt);

        $classAndMethod = $this->parseController($controller);

        $class = $classAndMethod['class'];
        $method = $classAndMethod['method'];

        if (empty($matches)) {
            $route = $this->createStaticRoute($path, $class, $method);
        } else {
            $start = 0;
            $length = 0;
            $tokens = array();
            $regex = $path;

            foreach ($matches as $match) {
                $tmp = '';
                $length = $match[0][1] - $start;

                if (isset($requirements[$match[1][0]])) {
                    $tmp .= sprintf('(?<%s>%s)', $match[1][0], $requirements[$match[1][0]]);
                } else {
                    $tmp .= sprintf('(?<%s>%s)', $match[1][0], $this->defaultNamedGroupPattern);
                }

                if (strncmp($this->optionalStartingChar, $match[0][0], 1) === 0) {
                    $tmp = '?' . $tmp . '?';
                }

                $start = $match[0][1] + strlen($match[0][0]);
                $tokens[] = $match[1][0];

                $regex = str_replace($match[0][0], $tmp, $regex);
            }

            $regex = '#^' . $regex . '$#Du';

            $route = $this->createRegexRoute($regex, $class, $method);
        }

        $route->setDefaults($defaults)
              ->setRequirements($requirements)
              ->setHttpMethod($httpMethod);

        return $route;
    }

    /**
     * @internal
     *
     * @return string
     */
    protected function createRequiredRegex()
    {
        return '#\\' . $this->requiredStartingChar . '([\w\d_=]+)\\' . $this->requiredEndingChar . '#u';
    }

    /**
     * @internal
     *
     * @return string
     */
    protected function createOptionalRegex()
    {
        return '#\\' . $this->optionalStartingChar . '([\w\d_=]+)\\' . $this->optionalEndingChar . '#u';
    }

    /**
     * @internal
     *
     * @param string $path
     * @param string $class
     * @param string $method
     *
     * @return StaticRoute
     */
    protected function createStaticRoute($path, $class, $method)
    {
        return new StaticRoute($path, $class, $method);
    }

    /**
     * @internal
     *
     * @param string $path
     * @param string $class
     * @param string $method
     *
     * @return RegexRoute
     */
    protected function createRegexRoute($path, $class, $method)
    {
        return new RegexRoute($path, $class, $method);
    }

    /**
     * Parses a string and returns an array with
     * the corresponding class and method.
     *
     * @internal
     *
     * @param string $controller
     *
     * @throws \InvalidArgumentException If the provided argument is malformed.
     *
     * @return array
     */
    protected function parseController($controller)
    {
        $continue = false;
        $length = strlen($controller) - 1;
        $first = strpos($controller, ':');
        $last = strrpos($controller, ':');
        $count = substr_count($controller, ':');

        if ($first > 0 && $last < $length) {
            $doubleColonCount = substr_count($controller, '::');
            if ($doubleColonCount === 1) {
                $count -= 2;
                if ($count > 0) {
                    list($class, $action) = explode('::', $controller, 2);
                    if (strpos($action, ':') === false) {
                        $continue = true;
                    }
                }
            } elseif ($doubleColonCount < 1) {
                $class = $controller;
                $continue = true;
            }

            if ($continue) {
                $pos = strripos($class, ':') + 1;
                $rest = substr($class, $pos);
                $rest = 'Controller:' . $rest . 'Controller';
                $class = substr_replace($class, $rest, $pos);
                $class = str_replace(':', '\\', $class);
                $action = (isset($action)) ? $action . 'Action' : 'indexAction';

                return array(
                    'class' => $class,
                    'method' => $action
                );
            }
        }

        throw new \InvalidArgumentException(sprintf(
            'The string "%s" is malformed. Check the syntax.',
            $controller
        ));
    }
}
