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
    const NAMED_GROUP_PATTERN = '[\w.~-]+';

    const OPTIONAL_PLACEHOLDER_PATTERN = '#\<([\w\d_=]*)\>#u';

    const REQUIRED_PLACEHOLDER_PATTERN = '#\{([\w\d_=]*)\}#u';

    /**
     * @param Route $route
     *
     * @return array
     */
    public function compile(Route $route)
    {
        $path = $route->getPath();

        preg_match_all(self::REQUIRED_PLACEHOLDER_PATTERN, $path, $req, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);
        preg_match_all(self::OPTIONAL_PLACEHOLDER_PATTERN, $path, $opt, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);

        $matches = array_merge($req, $opt);

        if (empty($matches)) {
            $type = CompiledRoute::TYPE_STATIC;
        } else {
            foreach ($matches as $match) {
                if (empty($match[1][0])) {
                    throw new \LogicException(sprintf('Empty "%s" placeholder is not allowed.', $match[0][0]));
                }

                $tmp = sprintf('(?<%s>%s)', $match[1][0], self::NAMED_GROUP_PATTERN);

                if (strncmp('<', $match[0][0], 1) === 0) {
                    $tmp = '?' . $tmp . '?';
                }

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
}
