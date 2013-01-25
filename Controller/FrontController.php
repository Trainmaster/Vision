<?php
namespace Vision\Controller;

use Vision\Routing\Router;
use Vision\Http\Request;
use Vision\Http\Response;
use Locale;
use Exception;
use UnexpectedValueException;
use RuntimeException;

class FrontController 
{
    protected $container;
	
    protected $router;
	
    protected $request;
	
    protected $response;
   
    protected $parser = null;
	    
    public function __construct(Request $request, Router $router) 
    {
        $this->request = $request;        
        $this->router = $router;
        
        $locale = Locale::acceptFromHttp($this->request->server->get('HTTP_ACCEPT_LANGUAGE'));
        
        if ($locale !== null) {
            Locale::setDefault($locale);    
        }
    }
    
    public function setContainer($container) 
    {
        $this->container = $container;
    }
    
    public function getContainer() 
    {
        return $this->container;
    }
    
    public function setParser($parser) 
    {
        $this->parser = $parser;
        return $this;
    }
    
    public function getParser() 
    {
        if ($this->parser === null) {
            return new ControllerParser;
        }
        return $this->parser;
    }
	
    public function dispatch() 
    {     
        try {
            $route = $this->router->resolve($this->request);
            if ($route !== null) {
                $class = $route->getController();                
                $parser = $this->getParser();                
                $result = $parser->parse($class);                
                if (isset($result['class'], $result['action'])) {
                    $controller = new $result['class'];
                    $controller->request = $this->request;				
                    $controller->setContainer($this->container);
                    $response = $controller->{$result['action']}();                    
                    if ($response instanceof Response) {
                        return $response;
                    } else {
                        throw new UnexpectedValueException(sprintf(
                            'The action "%s" must return a response object.',
                            $result['action']
                        ));
                    } 
                } else {
                    throw new UnexpectedValueException(sprintf(
                        'The controller parser must return an array having the two keys "class" and "method".'
                    ));
                }
            } else {
                throw new RuntimeException('No matching route.');
            }
        } catch (Exception $e) {
            $this->handleException($e);
        }		
    }
    
    public function handleException(Exception $e) 
    {
        // To be implemented
    }
}