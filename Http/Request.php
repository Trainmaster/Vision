<?php
namespace Vision\Http;

use Vision\Http\RequestHandler;
use Vision\DataStructures\ArrayProxyObject;
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
        
    public function __construct()
    {
        $this->get = new ArrayProxyObject($_GET);
        $this->post = new ArrayProxyObject($_POST);
        $this->files = new ArrayProxyObject($_FILES);
        $this->cookie = new ArrayProxyObject($_COOKIE);
        $this->server = new ArrayProxyObject($_SERVER);
        
        $this->initMethod();
        
        $this->initBasePath();               
        $this->initPathInfo();
        $this->initPath(); 
    }
    
    public function __get($key)
    {
        if (isset($this->$key)) {
            return $this->$key;
        }
        return null;
    }
    
    public function __set($key, $value)
    {
        if (in_array($key, array('get', 'post', 'files', 'cookie', 'server'))) {
            throw new RuntimeException('You may not override the default request properties "get, post, files, cookie, server"');
        }
        $this->$key = $value;
        return $this;
    }
    
    public function getMethod()
    {
        return $this->method;
    }
    
    public function initMethod()
    {
        if (isset($this->server['REQUEST_METHOD'])) {
            $this->method = strtoupper($this->server['REQUEST_METHOD']);
        }
        
        return $this;
    }
    
    public function isPost()
    {
        return $this->method === 'POST' ? true : false;
    }
    
    public function isGet()
    {
        return $this->method === 'GET' ? true : false;
    }
    
    public function isHead()
    {
        return $this->method === 'HEAD' ? true : false;
    }
    
    public function isPut()
    {
        return $this->method === 'PUT' ? true : false;
    }
    
    /**
     * Get base path of current url
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
     * Get path info of current url
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
     * Get path of current url
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
    
    protected function initPath()
    {
        $path = $this->getBasePath() . $this->getPathInfo();
        
        $this->path = rtrim($path, '/');
        
        return $this;
    }
}