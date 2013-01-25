<?php
namespace Vision\Http;

use Vision\Http\RequestHandler;

class RequestException extends \Exception {}

class Request implements RequestInterface
{
    private $get = null;
    
    private $post = null;

    private $files = null;
    
    private $cookie = null;
    
    private $server = null;
    
    protected $baseUrl = null;
    
    protected $method = null;
    
    protected $path = null;
        
    public function __construct ()
    {
        $this->get = new RequestHandler($_GET);
        $this->post = new RequestHandler($_POST);
        $this->files = new RequestHandler($_FILES);
        $this->cookie = new RequestHandler($_COOKIE);
        $this->server = new RequestHandler($_SERVER);
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
            throw new RequestException('You may not override the default request properties "get, post, files, cookie, server"');
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
    
    public function setBaseUrl($baseUrl)
    {
        $baseUrl = trim($baseUrl);
        $this->baseUrl = rtrim($baseUrl, '/');
        return $this;
    }
    
    public function getBaseUrl() 
    {
        if ($this->baseUrl === null) {
            $dirName = dirname($this->server->get('SCRIPT_NAME'));
            if ($dirName !== '.') {
                $this->setBaseUrl($dirName);
            }
        }
        return $this->baseUrl;
    }
    
    public function getPath() 
    {            
        if ($this->path === null) {        
            $path = str_replace($this->getBaseUrl(), '', $this->server->get('REQUEST_URI'));
            $this->path = parse_url($path, PHP_URL_PATH);
        }
        return $this->path;
    }
}