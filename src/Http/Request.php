<?php

declare(strict_types=1);

namespace Vision\Http;

use Vision\DataStructures\Arrays\Mutator\SquareBracketNotation;
use Vision\Url\Url;

class Request extends Message implements RequestInterface
{
    /** @var Url */
    private $url;

    /** @var SquareBracketNotation $queryParams */
    private $queryParams;

    /** @var SquareBracketNotation $bodyParams */
    private $bodyParams;

    /** @var SquareBracketNotation $serverParams */
    private $serverParams;

    /** @var SquareBracketNotation $files */
    private $files;

    /** @var SquareBracketNotation $cookies */
    private $cookies;

    /** @var string|null $method */
    private $method;

    /** @var string|null $basePath */
    private $basePath;

    /** @var string|null $pathInfo */
    private $pathInfo;

    /**
     * @param Url $url
     * @param array $queryParams
     * @param array $bodyParams
     * @param array $serverParams
     * @param array $files
     * @param array $cookies
     */
    public function __construct(
        Url $url,
        array $queryParams,
        array $bodyParams,
        array $serverParams,
        array $files,
        array $cookies
    ) {
        $this->url = $url;
        $this->queryParams = new SquareBracketNotation($queryParams);
        $this->bodyParams = new SquareBracketNotation($bodyParams);
        $this->serverParams = new SquareBracketNotation($serverParams);
        $this->files = new SquareBracketNotation($files);
        $this->cookies = new SquareBracketNotation($cookies);

        if (isset($this->serverParams['REQUEST_METHOD'])) {
            $this->method = strtoupper($this->serverParams['REQUEST_METHOD']);
        }

        $this->initBasePath()
             ->initPathInfo();
    }

    /**
     * @return Url
     */
    public function getUrl(): Url
    {
        return $this->url;
    }

    /**
     * @return SquareBracketNotation
     */
    public function getQueryParams(): SquareBracketNotation
    {
        return $this->queryParams;
    }

    /**
     * @return SquareBracketNotation
     */
    public function getBodyParams(): SquareBracketNotation
    {
        return $this->bodyParams;
    }

    /**
     * @return SquareBracketNotation
     */
    public function getServerParams(): SquareBracketNotation
    {
        return $this->serverParams;
    }

    /**
     * @return SquareBracketNotation
     */
    public function getFiles(): SquareBracketNotation
    {
        return $this->files;
    }

    /**
     * @return SquareBracketNotation
     */
    public function getCookies(): SquareBracketNotation
    {
        return $this->cookies;
    }

    /**
     * @return bool
     */
    public function isPost(): bool
    {
        return $this->method === 'POST';
    }

    /**
     * @return bool
     */
    public function isGet(): bool
    {
        return $this->method === 'GET';
    }

    /**
     * @return bool
     */
    public function isHead(): bool
    {
        return $this->method === 'HEAD';
    }

    /**
     * @return bool
     */
    public function isPut(): bool
    {
        return $this->method === 'PUT';
    }

    /**
     * @return bool
     */
    public function isDelete(): bool
    {
        return $this->method === 'DELETE';
    }

    /**
     * @return bool
     */
    public function isSecure(): bool
    {
        return $this->getUrl()->getScheme() === 'https';
    }

    /**
     * Returns the current request method.
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return (clone $this->getUrl())
            ->setPath($this->getBasePath() . '/')
            ->setQuery(null)
            ->setFragment(null)
            ->__toString();
    }

    /**
     * Get base path of current url.
     *
     * Example: http://www.example.com/foo/index.php/bar
     * Result: "/foo"
     *
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * Get path info of current url.
     *
     * Example: http://www.example.com/foo/index.php/bar
     * Result: "/bar"
     *
     * @return string
     */
    public function getPathInfo(): string
    {
        return $this->pathInfo;
    }

    /**
     * @return Request
     */
    private function initBasePath(): self
    {
        $basePath = '';

        if (isset($this->serverParams['SCRIPT_NAME'])) {
            $basePath = dirname($this->serverParams['SCRIPT_NAME']);
        }

        if ($basePath === '.') {
            $basePath = '';
        }

        if (DIRECTORY_SEPARATOR === '\\') {
            $basePath = str_replace('\\', '/', $basePath);
        }

        $this->basePath = rtrim($basePath, '/');

        return $this;
    }

    /**
     * @return Request
     */
    private function initPathInfo(): self
    {
        if (isset($this->serverParams['PATH_INFO'])) {
            $this->pathInfo = $this->serverParams['PATH_INFO'];
        } elseif (isset($this->serverParams['REQUEST_URI'])) {
            $scriptName = $this->serverParams['SCRIPT_NAME'] ?? '';
            $pathInfo = str_replace($scriptName, '', $this->serverParams['REQUEST_URI']);
            $pathInfoWithoutQueryString = strstr($pathInfo, '?', true);
            $this->pathInfo = $pathInfoWithoutQueryString ?: $pathInfo;
        }

        return $this;
    }
}
