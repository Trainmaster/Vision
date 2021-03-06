<?php

declare(strict_types=1);

namespace Vision\Routing;

class RouteCompiler
{
    private const NAMED_GROUP_PATTERN = '[\w.~-]+';

    private const OPTIONAL_PLACEHOLDER_PATTERN = '#\<([\w\d_=]*)\>#u';

    private const REQUIRED_PLACEHOLDER_PATTERN = '#\{([\w\d_=]*)\}#u';

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
