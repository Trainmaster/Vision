<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Http;

use Vision\DataStructures\SuperglobalProxyObject;
use RuntimeException;

/**
 * Request
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Request extends AbstractMessage implements RequestInterface
{
    /** @type null|SuperglobalProxyObject $GET */
    protected $GET = null;

    /** @type null|SuperglobalProxyObject $POST */
    protected $POST = null;

    /** @type null|SuperglobalProxyObject $FILES */
    protected $FILES = null;

    /** @type null|SuperglobalProxyObject $COOKIE */
    protected $COOKIE = null;

    /** @type null|SuperglobalProxyObject $SERVER */
    protected $SERVER = null;

    /** @type null|string $method */
    protected $method = null;

    /** @type null|string $host */
    protected $host = null;

    /** @type null|string $basePath */
    protected $basePath = null;

    /** @type null|string $path */
    protected $path = null;

    /** @type null|string $pathInfo */
    protected $pathInfo = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->GET = new SuperglobalProxyObject($_GET);
        $this->POST = new SuperglobalProxyObject($_POST);
        $this->FILES = new SuperglobalProxyObject($_FILES);
        $this->COOKIE = new SuperglobalProxyObject($_COOKIE);
        $this->SERVER = new SuperglobalProxyObject($_SERVER);

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
     * @api
     *
     * @return bool
     */
    public function isPost()
    {
        return $this->method === 'POST' ? true : false;
    }

    /**
     * Check, if the current request method is GET.
     *
     * @api
     *
     * @return bool
     */
    public function isGet()
    {
        return $this->method === 'GET' ? true : false;
    }

    /**
     * Check, if the current request method is HEAD.
     *
     * @api
     *
     * @return bool
     */
    public function isHead()
    {
        return $this->method === 'HEAD' ? true : false;
    }

    /**
     * Check, if the current request method is PUT.
     *
     * @api
     *
     * @return bool
     */
    public function isPut()
    {
        return $this->method === 'PUT' ? true : false;
    }

    /**
     * Check, if the current request method is DELETE.
     *
     * @api
     *
     * @return bool
     */
    public function isDelete()
    {
        return $this->method === 'DELETE' ? true : false;
    }

    /**
     * @api
     *
     * @return null|string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @internal
     *
     * @return $this Provides a fluent interface.
     */
    protected function initHost()
    {
        $host = $this->SERVER['HTTP_HOST'];

        if ($host === null) {
            return $this;
        }

        if (strlen($host > 255)) {
            return $this;
        }

        if (preg_match('#^[-._A-Za-z0-9]+$#', $host)) {
            $this->host = $host;
        }

        return $this;
    }

    /**
     * Returns the current request method.
     *
     * @api
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Get base path of current url.
     *
     * Example: http://www.example.com/foo/index.php/bar
     * Result: "/foo"
     *
     * @api
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @internal
     *
     * @return $this Provides a fluent interface.
     */
    protected function initBasePath()
    {
        if (isset($this->SERVER['SCRIPT_NAME'])) {
            $path = dirname($this->SERVER['SCRIPT_NAME']);
        }

        if ($path !== '.') {
            $this->basePath = $path;
        }

        if ($path === '/') {
            $this->basePath = '';
        }

        return $this;
    }

    /**
     * Get path info of current url.
     *
     * Example: http://www.example.com/foo/index.php/bar
     * Result: "/bar"
     *
     * @api
     *
     * @return string
     */
    public function getPathInfo()
    {
        return $this->pathInfo;
    }

    /**
     * @internal
     *
     * @return $this Provides a fluent interface.
     */
    protected function initPathInfo()
    {
        if (isset($this->SERVER['PATH_INFO'])) {
            $pathInfo = $this->SERVER['PATH_INFO'];
        } elseif (isset($this->SERVER['ORIG_PATH_INFO'])) {
            $pathInfo = $this->SERVER['ORIG_PATH_INFO'];
        } elseif (isset($this->SERVER['REQUEST_URI'])) {
            $pathInfo = str_replace($this->getBasePath(), '', $this->SERVER['REQUEST_URI']);
        }

        $this->pathInfo = $pathInfo;

        return $this;
    }

    /**
     * Get path of current url.
     *
     * Example: http://www.example.com/foo/index.php/bar
     * Result: "/foo/index.php/bar"
     *
     * @api
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @internal
     *
     * @return $this Provides a fluent interface.
     */
    protected function initPath()
    {
        $path = $this->getBasePath() . $this->getPathInfo();

        $this->path = rtrim($path, '/');

        return $this;
    }
}
