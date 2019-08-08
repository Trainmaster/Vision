<?php
declare(strict_types = 1);

namespace Vision\Url;

class UrlFromServerFactory
{
    /**
     * Allows to create a url from $_SERVER superglobal
     * @param array $server
     * @return Url
     */
    public static function make(array $server): Url
    {
        return (new Url())
            ->setScheme(self::extractScheme($server))
            ->setHost(self::extractHost($server))
            ->setPort(self::extractPort($server))
            ->setPath(self::extractPath($server))
            ->setQuery(self::extractQuery($server));
    }

    /**
     * @param array $server
     * @return string
     */
    private static function extractScheme(array $server): string
    {
        $isHttps = !empty($server['HTTPS']) && $server['HTTPS'] !== 'off';
        return $isHttps ? 'https' : 'http';
    }

    /**
     * @param array $server
     * @return string
     */
    private static function extractHost(array $server): string
    {
        $host = $server['SERVER_NAME'] ?? $server['HTTP_HOST'] ?? '';

        if (strlen($host) > 255) {
            return '';
        }

        preg_match('#^([-._A-Za-z0-9]+)(:[0-9]+)?$#D', $host, $matches);

        return $matches[1] ?? '';
    }

    /**
     * @param array $server
     * @return int|null
     */
    private static function extractPort(array $server): ?int
    {
        return isset($server['SERVER_PORT']) ? (int)$server['SERVER_PORT'] : null;
    }

    /**
     * @param array $server
     * @return string
     */
    private static function extractPath(array $server): string
    {
        $requestUri = $server['REQUEST_URI'] ?? '';
        $requestUriWithoutQueryString = strstr($requestUri, '?', true);
        return $requestUriWithoutQueryString ?: $requestUri;
    }

    /**
     * @param array $server
     * @return string|null
     */
    private static function extractQuery(array $server): ?string
    {
        $queryString = $server['QUERY_STRING'] ?? null;
        return $queryString !== '' ? $queryString : null;
    }
}
