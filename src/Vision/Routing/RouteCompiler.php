<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Routing;

class RouteCompiler
{
    /** @var string $requiredStartingChar */
    protected $requiredStartingChar = '{';

    /** @var string $requiredEndingChar */
    protected $requiredEndingChar = '}';

    /** @var string $optionalStartingChar */
    protected $optionalStartingChar = '<';

    /** @var string $optionalEndingChar */
    protected $optionalEndingChar = '>';

    /** @var string $defaultNamedGroupPattern */
    protected $defaultNamedGroupPattern = '[\w.~-]+';

    /**
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
     * @param Route $route
     *
     * @return AbstractCompiledRoute
     */
    public function compile(Route $route)
    {
        $path = $route->getPath();
        $controller = $route->getHandler();
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
            $tokens = [];
            $regex = $path;

            foreach ($matches as $match) {
                $tmp = sprintf('(?<%s>%s)', $match[1][0], $this->defaultNamedGroupPattern);

                if (strncmp($this->optionalStartingChar, $match[0][0], 1) === 0) {
                    $tmp = '?' . $tmp . '?';
                }

                $tokens[] = $match[1][0];

                $regex = str_replace($match[0][0], $tmp, $regex);
            }

            $regex = '#^' . $regex . '$#Du';

            $route = $this->createRegexRoute($regex, $class, $method);
        }

        $route->setHttpMethod($httpMethod);

        return $route;
    }

    /**
     * @return string
     */
    protected function createRequiredRegex()
    {
        return '#\\' . $this->requiredStartingChar . '([\w\d_=]+)\\' . $this->requiredEndingChar . '#u';
    }

    /**
     * @return string
     */
    protected function createOptionalRegex()
    {
        return '#\\' . $this->optionalStartingChar . '([\w\d_=]+)\\' . $this->optionalEndingChar . '#u';
    }

    /**
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

                return [
                    'class' => $class,
                    'method' => $action
                ];
            }
        }

        throw new \InvalidArgumentException(sprintf(
            'The string "%s" is malformed. Check the syntax.',
            $controller
        ));
    }
}
