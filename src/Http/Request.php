<?php
declare(strict_types = 1);

namespace Vision\Http;

use Vision\DataStructures\Arrays\Mutator\SquareBracketNotation;

class Request extends Message implements RequestInterface
{
    /** @var null|SquareBracketNotation $GET */
    protected $GET;

    /** @var null|SquareBracketNotation $POST */
    protected $POST;

    /** @var null|SquareBracketNotation $FILES */
    protected $FILES;

    /** @var null|SquareBracketNotation $COOKIE */
    protected $COOKIE;

    /** @var null|SquareBracketNotation $SERVER */
    protected $SERVER;

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
     * @param array $queryParams
     * @param array $bodyParams
     * @param array $serverParams
     * @param array $files
     * @param array $cookies
     */
    public function __construct(
        array $queryParams,
        array $bodyParams,
        array $serverParams,
        array $files,
        array $cookies)
    {
        $this->GET = new SquareBracketNotation($queryParams);
        $this->POST = new SquareBracketNotation($bodyParams);
        $this->SERVER = new SquareBracketNotation($serverParams);
        $this->FILES = new SquareBracketNotation($files);
        $this->COOKIE = new SquareBracketNotation($cookies);

        // Set $this->method
        if (isset($this->SERVER['REQUEST_METHOD'])) {
            $this->method = strtoupper($this->SERVER['REQUEST_METHOD']);
        }

        $this->initHost()
             ->initBasePath()
             ->initPathInfo()
             ->initPath();
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        $key = strtoupper($key);

        if (isset($this->$key)) {
            return $this->$key;
        }

        return null;
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
        return (!empty($this->SERVER['HTTPS']) && $this->SERVER['HTTPS'] !== 'off');
    }

    /**
     * @return bool
     */
    public function isXmlHttpRequest()
    {
        return (isset($this->SERVER['HTTP_X_REQUESTED_WITH'])
                && $this->SERVER['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest");
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
        $host = $this->SERVER['HTTP_HOST'];

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
    public function getUrl()
    {
        $url = $this->getScheme() . '://' . $this->getHost() . $this->getPath();

        if ($this->getQueryString()) {
            $url .= '?' . $this->getQueryString();
        }

        return $url;
    }

    /**
     * @return string
     */
    public function getQueryString()
    {
        return $this->SERVER['QUERY_STRING'];
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

        if (isset($this->SERVER['SCRIPT_NAME'])) {
            $basePath = dirname($this->SERVER['SCRIPT_NAME']);
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

        if (isset($this->SERVER['PATH_INFO'])) {
            $pathInfo = $this->SERVER['PATH_INFO'];
        } elseif (isset($this->SERVER['REQUEST_URI'])) {
            $pathInfo = str_replace($this->SERVER['SCRIPT_NAME'] ?? '', '', $this->SERVER['REQUEST_URI']);
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
