<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Http;

use Vision\DataStructures\Arrays\Mutator\SquareBracketNotation;

/**
 * Request
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Request extends AbstractMessage implements RequestInterface
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
     * Constructor
     */
    public function __construct()
    {
        $this->GET = new SquareBracketNotation($_GET);
        $this->POST = new SquareBracketNotation($_POST);
        $this->FILES = new SquareBracketNotation($this->transformFilesArray($_FILES));
        $this->COOKIE = new SquareBracketNotation($_COOKIE);
        $this->SERVER = new SquareBracketNotation($_SERVER);

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
        return $this->method === 'POST';
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
        return $this->method === 'GET';
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
        return $this->method === 'HEAD';
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
        return $this->method === 'PUT';
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
        return $this->method === 'DELETE';
    }

    /**
     * @see http://www.php.net/manual/en/reserved.variables.server.php
     *
     * @api
     *
     * @return bool
     */
    public function isSecure()
    {
        return (!empty($this->SERVER['HTTPS']) && $this->SERVER['HTTPS'] !== 'off');
    }

    /**
     * @api
     *
     * @return bool
     */
    public function isXmlHttpRequest()
    {
        return (isset($this->SERVER['HTTP_X_REQUESTED_WITH'])
                && $this->SERVER['HTTP_X_REQUESTED_WITH'] === "XMLHttpRequest");
    }

    /**
     * @api
     *
     * @return string
     */
    public function getScheme()
    {
        return $this->isSecure() ? 'https' : 'http';
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
     * @api
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->getScheme() . '://' . $this->getHost() . $this->getBasePath();
    }

    /**
     * @api
     *
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
     * @api
     *
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

    /**
     * @internal
     *
     * @param array $files
     *
     * @return array
     */
    protected function transformFilesArray(array $files)
    {
        foreach ($files as &$value) {
            $newArray = array();

            foreach ($value as $key => $val) {
                if (is_array($val)) {
                    array_walk_recursive($val, function(&$item) use($key) {
                        $item = array($key => $item);
                    });
                    $newArray = array_replace_recursive($newArray, $val);
                }
            }

            if (!empty($newArray)) {
                $value = $newArray;
            }
        }

        return $files;
    }
}
