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
 * @author Frank Liepert
 */
class Request extends AbstractMessage implements RequestInterface
{
    private $get = null;
    
    private $post = null;

    private $files = null;
    
    private $cookie = null;
    
    private $server = null;

    protected $method = null;
    
    protected $basePath = null;
    
    protected $path = null;   
    
    protected $pathInfo = null;
        
    /**
     * @return void
     */
    public function __construct()
    {
        $this->get = new SuperglobalProxyObject($_GET);
        $this->post = new SuperglobalProxyObject($_POST);
        $this->files = new SuperglobalProxyObject($_FILES);
        $this->cookie = new SuperglobalProxyObject($_COOKIE);
        $this->server = new SuperglobalProxyObject($_SERVER);
        
        $this->initMethod();        
        $this->initBasePath();               
        $this->initPathInfo();
        $this->initPath(); 
    }
    
    /**
     * @param string $key 
     * 
     * @return mixed|null
     */
    public function __get($key)
    {
        if (isset($this->$key)) {
            return $this->$key;
        }
        return null;
    }
    
    /**
     * @param string $key 
     * @param mixed $value 
     * 
     * @return Request Provides a fluent interface.
     */
    public function __set($key, $value)
    {
        if (in_array($key, array('get', 'post', 'files', 'cookie', 'server'))) {
            throw new RuntimeException('You may not override the default request properties "get, post, files, cookie, server"');
        }
        
        $this->$key = $value;
        
        return $this;
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
     * @return Request Provides a fluent interface.
     */
    public function initMethod()
    {
        if (isset($this->server['REQUEST_METHOD'])) {
            $this->method = strtoupper($this->server['REQUEST_METHOD']);
        }
        
        return $this;
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
     * @return Request Provides a fluent interface.
     */
    protected function initBasePath()
    {
        if (isset($this->server['SCRIPT_NAME'])) {
            $path = dirname($this->server['SCRIPT_NAME']);
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
     * @return Request Provides a fluent interface.
     */
    protected function initPathInfo()
    {
        if (isset($this->server['PATH_INFO'])) {
            $pathInfo = $this->server['PATH_INFO'];
        } elseif (isset($this->server['ORIG_PATH_INFO'])) {
            $pathInfo = $this->server['ORIG_PATH_INFO'];
        } elseif (isset($this->server['REQUEST_URI'])) {
            $pathInfo = str_replace($this->getBasePath(), '', $this->server['REQUEST_URI']);
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
     * @return Request Provides a fluent interface.
     */
    protected function initPath()
    {
        $path = $this->getBasePath() . $this->getPathInfo();
        
        $this->path = rtrim($path, '/');
        
        return $this;
    }
}