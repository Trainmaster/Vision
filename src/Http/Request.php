<?php
declare(strict_types = 1);

namespace Vision\Http;

use Vision\DataStructures\Arrays\Mutator\SquareBracketNotation;

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

    /** @var null|string $method */
    protected $method;

    /** @var null|string $host */
    protected $host;

    /** @var null|string $basePath */
    protected $basePath;

    /** @var null|string $path */
    protected $path;

    /** @var null|string $pathInfo */
    protected $pathInfo;

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
        array $cookies)
    {
        $this->url = $url;
        $this->queryParams = new SquareBracketNotation($queryParams);
        $this->bodyParams = new SquareBracketNotation($bodyParams);
        $this->serverParams = new SquareBracketNotation($serverParams);
        $this->files = new SquareBracketNotation($files);
        $this->cookies = new SquareBracketNotation($cookies);

        if (isset($this->serverParams['REQUEST_METHOD'])) {
            $this->method = strtoupper($this->serverParams['REQUEST_METHOD']);
        }

        $this->initHost()
             ->initBasePath()
             ->initPathInfo()
             ->initPath();
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
     * Check, if the current request method is POST.
     *
     * @return bool
     */
    public function isPost()
    {
        return $this->method === 'POST';
    }

    /**
     * Check, if the current request method is GET.
     *
     * @return bool
     */
    public function isGet()
    {
        return $this->method === 'GET';
    }

    /**
     * Check, if the current request method is HEAD.
     *
     * @return bool
     */
    public function isHead()
    {
        return $this->method === 'HEAD';
    }

    /**
     * Check, if the current request method is PUT.
     *
     * @return bool
     */
    public function isPut()
    {
        return $this->method === 'PUT';
    }

    /**
     * Check, if the current request method is DELETE.
     *
     * @return bool
     */
    public function isDelete()
    {
        return $this->method === 'DELETE';
    }

    /**
     * @see http://www.php.net/manual/en/reserved.variables.server.php
     *
     * @return bool
     */
    public function isSecure()
    {
        return (!empty($this->serverParams['HTTPS']) && $this->serverParams['HTTPS'] !== 'off');
    }

    /**
     * @return bool
     */
    public function isXmlHttpRequest()
    {
        return (isset($this->serverParams['HTTP_X_REQUESTED_WITH'])
                && $this->serverParams['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest");
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->isSecure() ? 'https' : 'http';
    }

    /**
     * @return null|string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return $this Provides a fluent interface.
     */
    protected function initHost()
    {
        $host = $this->serverParams['HTTP_HOST'];

        if ($host === null) {
            return $this;
        }

        if (strlen($host) > 255) {
            return $this;
        }

        if (preg_match('#^[-._A-Za-z0-9]+$#D', $host)) {
            $this->host = $host;
        }

        return $this;
    }

    /**
     * Returns the current request method.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->getScheme() . '://' . $this->getHost() . $this->getBasePath();
    }

    /**
     * @return string
     */
    public function getQueryString()
    {
        return $this->serverParams['QUERY_STRING'];
    }

    /**
     * Get base path of current url.
     *
     * Example: http://www.example.com/foo/index.php/bar
     * Result: "/foo"
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @return $this Provides a fluent interface.
     */
    protected function initBasePath()
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
     * Get path info of current url.
     *
     * Example: http://www.example.com/foo/index.php/bar
     * Result: "/bar"
     *
     * @return string
     */
    public function getPathInfo()
    {
        return $this->pathInfo;
    }

    /**
     * @return $this Provides a fluent interface.
     */
    protected function initPathInfo()
    {
        $pathInfo = '';

        if (isset($this->serverParams['PATH_INFO'])) {
            $pathInfo = $this->serverParams['PATH_INFO'];
        } elseif (isset($this->serverParams['REQUEST_URI'])) {
            $pathInfo = str_replace($this->serverParams['SCRIPT_NAME'] ?? '', '', $this->serverParams['REQUEST_URI']);
        }

        $pathInfoWithoutQueryString = strstr($pathInfo, '?', true);

        $this->pathInfo = $pathInfoWithoutQueryString ?: $pathInfo;

        return $this;
    }

    /**
     * Get path of current url.
     *
     * Example: http://www.example.com/foo/index.php/bar
     * Result: "/foo/index.php/bar"
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return $this Provides a fluent interface.
     */
    protected function initPath()
    {
        $path = $this->getBasePath() . $this->getPathInfo();

        $this->path = rtrim($path, '/');

        return $this;
    }
}
