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
     * @return array
     */
    public function compile(Route $route)
    {
        $path = $route->getPath();

        $reqRegex = $this->createRequiredRegex();
        $optRegex = $this->createOptionalRegex();

        preg_match_all($reqRegex, $path, $req, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);
        preg_match_all($optRegex, $path, $opt, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);

        $matches = array_merge($req, $opt);

        if (empty($matches)) {
            $type = CompiledRoute::TYPE_STATIC;
        } else {
            $tokens = [];
            foreach ($matches as $match) {
                $tmp = sprintf('(?<%s>%s)', $match[1][0], $this->defaultNamedGroupPattern);

                if (strncmp($this->optionalStartingChar, $match[0][0], 1) === 0) {
                    $tmp = '?' . $tmp . '?';
                }

                $tokens[] = $match[1][0];

                $path = str_replace($match[0][0], $tmp, $path);
            }
            $path = '#^' . $path . '$#Du';
            $type = CompiledRoute::TYPE_REGEX;
        }

        return [
            'httpMethod' => $route->getHttpMethod(),
            'handler' => $route->getHandler(),
            'path' => $path,
            'type' => $type,
        ];
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
}
