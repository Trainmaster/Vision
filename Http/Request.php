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
    
    protected $basePath = null;
    
    protected $method = null;
    
    protected $path = null;
        
    public function __construct($GET = null, $POST = null, $FILES = null, $COOKIE = null)
    {
        $this->get = new ArrayProxyObject($_GET);
        $this->post = new ArrayProxyObject($_POST);
        $this->files = new RequestHandler($_FILES);
        $this->cookie = new RequestHandler($_COOKIE);
        $this->server = new RequestHandler($_SERVER);
        // $this->setVersion($this->server->get('SERVER_PROTOCOL'));
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
        if ($this->method === null) {
            $method = $this->server->get('REQUEST_METHOD');
            $method = strtoupper($method);
        }
        return $this->method;
    }
    
    public function setBasePath($basePath)
    {
        $basePath = trim($basePath);
        $this->basePath = rtrim($basePath, '/');
        return $this;
    }
    
    public function getBasePath()
    {
        if ($this->basePath === null) {
            $this->setBasePath($this->findBasePath());            
        }
        return $this->basePath;
    }
    
    protected function findBasePath()
    {
        if ($this->server->get('SCRIPT_NAME') !== null) {
            $basePath = dirname($this->server->get('SCRIPT_NAME'));
            if ($basePath !== '.') {
                return $basePath;
            }
        }
        return null;
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
        if ($this->path === null) {
            $this->path = $this->findPathInfo();
        }
        return $this->path;
    }
    
    protected function findPathInfo()
    {
        if ($this->server->get('PATH_INFO') !== null) {
            $pathInfo = $this->server->get('PATH_INFO');
        } elseif ($this->server->get('ORIG_PATH_INFO') !== null) {
            $pathInfo = $this->server->get('ORIG_PATH_INFO');
        } else {
            $pathInfo = str_replace($this->getBasePath(), '', $this->server->get('REQUEST_URI'));
        }
        return $pathInfo;
    }
}