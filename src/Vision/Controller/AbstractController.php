<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Controller;

use Vision\Crypt\Random;
use Vision\Http\RequestInterface;
use Vision\Http\RequestAwareInterface;
use Vision\Http\ResponseInterface;
use Vision\Http\ResponseAwareInterface;
use Vision\Session\Session;
use Vision\Session\SessionAwareInterface;
use Vision\Http\Url;
use Vision\Http\UrlAwareInterface;
use Vision\Templating\TemplateEngineAwareInterface;

/**
 * AbstractController
 *
 * @author Frank Liepert
 */
abstract class AbstractController implements RequestAwareInterface, ResponseAwareInterface, 
                                             TemplateEngineAwareInterface, SessionAwareInterface,
                                             UrlAwareInterface, ControllerInterface
{      
    protected $request = null;
    
    protected $response = null;
    
    protected $session = null;
    
    protected $template = null;
    
    protected $url = null;
    
    public function preFilter()
    {    
        if (!isset($this->session['token'])) {
            $random = new Random;
            $token = $random->generateHex(128);
            $this->session['token'] = $token;
        }
    }
    
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
        return $this;
    }
    
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
        return $this;
    }
    
    public function setSession(Session $session)
    {
        $this->session = $session;
        return $this;
    }
    
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }
    
    public function setUrl(Url $url)
    {
        $this->url = $url;
        return $this;
    }
    
    public function redirect($url)
    {
        $url = $this->url->parse($url);
        
        if ($url === false) {
            return false;
        }
        
        $url = $this->populateUrlParameters($url);
        $url = $this->url->build($url);
        
        if ($this->response === null || $url === false) {
            return false;
        }
        
        $this->response->addHeader('Location', $url)
                       ->setStatusCode(302)
                       ->send();
        exit;     
    }
    
    public function populateUrlParameters(array $url)
    {
        if ($this->request === null) {
            return $url;
        }
        
        if (!isset($url['scheme'])) {
            if (isset($this->request->SERVER['HTTPS'])) {
                $scheme = 'https';
            } else {
                $scheme = 'http';
            }
            $url['scheme'] = $scheme;
        }
        
        if (!isset($url['host'])) {
            if (isset($this->request->SERVER['SERVER_NAME'])) {
                $url['host'] = $this->request->SERVER['SERVER_NAME'];
            }
        }
        
        $path = $this->request->getBasePath();
        if (!isset($url['path']) && isset($path)) {            
            $url['path'] = $path;
        } else {
            if (strpos($url['path'], '/') !== 0) {
                $url['path'] = '/' . $url['path'];
            }
            $url['path'] = $path . $url['path'];
        }
        
        return $url;    
    }
}