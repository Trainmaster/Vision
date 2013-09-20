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
 * This class provides a base for all controllers and may be customized.
 *
 * @author Frank Liepert
 */
abstract class AbstractController implements RequestAwareInterface, ResponseAwareInterface, 
                                             TemplateEngineAwareInterface, SessionAwareInterface,
                                             UrlAwareInterface, ControllerInterface
{      
    /** @type RequestInterface $request */
    protected $request = null;
    
    /** @type ResponseInterface $response */
    protected $response = null;
    
    /** @type Session $session */
    protected $session = null;
    
    /** @type null|object $template */
    protected $template = null;
    
    /** @type Url $url */
    protected $url = null;
    
    /**
     * This method will be called right after instantiating the controller.
     *
     * @api
     * 
     * @return void
     */
    public function preFilter()
    {
        $this->initSessionToken();
    }
    
    /**
     * This method will be called right after invoking the controller action.
     *
     * @api
     * 
     * @return void
     */
    public function postFilter()
    {
    }
    
    /**
     * @api
     * 
     * @param RequestInterface $request 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
        return $this;
    }
    
    /**
     * @api
     * 
     * @param ResponseInterface $response 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
        return $this;
    }
    
    /**
     * @api
     * 
     * @param Session $session 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setSession(Session $session)
    {
        $this->session = $session;
        return $this;
    }
    
    /**
     * @api
     * 
     * @param object $template 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }
    
    /**
     * @api
     * 
     * @param Url $url 
     * 
     * @return $this Provides a fluent interface.
     */
    public function setUrl(Url $url)
    {
        $this->url = $url;
        return $this;
    }    
    
    /**
     * This is a shorthand method for creating a redirect response.
     *
     * @api
     * 
     * @param string $url 
     * 
     * @return bool|ResponseInterface
     */
    public function redirect($url)
    {
        $url = parse_url($url);
        
        if (!$url) {
            return false;
        }
        
        $url = $this->url->populateUrlParameters($url, $this->request);
        $url = $this->url->build($url);
        
        if ($this->response === null || $url === false) {
            return false;
        }
        
        $this->response->addHeader('Location', $url)
                       ->setStatusCode(302);
        
        return $this->response;
    }   
    
    /**
     * This method is for session token generation and may be overridden.
     *
     * @internal
     * 
     * @return void
     */
    protected function initSessionToken()
    {
        if (isset($this->session) && !isset($this->session['token'])) {
            $random = new Random;
            $token = $random->generateHex(128);
            $this->session['token'] = $token;
        }
    }
}