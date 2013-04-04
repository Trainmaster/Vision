<?php
namespace Vision\Controller;

use Vision\DependencyInjection\ContainerInterface;
use Vision\Http\RequestInterface;
use Vision\Http\ResponseInterface;
use Vision\Routing\Router;
use Exception;
use UnexpectedValueException;
use RuntimeException;

class FrontController 
{
    protected $container = null;
    
    protected $request = null;
    
    protected $response = null;   
    
    protected $router = null;
	    
    public function __construct(RequestInterface $request, ResponseInterface $response, Router $router, ContainerInterface $container) 
    {
        $this->request = $request; 
        $this->response = $response;
        $this->router = $router;
        $this->container = $container;
    }

    public function getRequest()
    {
        return $this->request;
    }
    
    public function getResponse()
    {
        return $this->response;
    }
    
    public function getRouter()
    {
        return $this->router;
    }
    
    public function invokeController($class, $method)
    {        
        if ($this->container->isDefined($class)) {
            // To do: What if $class is not defined in container? wireUp... will result in an error
            // print_r (get_declared_classes());
            $this->wireUpInterfaceAwareDependencies($class);
            $instance = $this->container->get($class);   
            $instance->preFilter();
            if (method_exists($instance, $method)) {
                return $instance->$method();
            }
        }
    }
    
    public function wireUpInterfaceAwareDependencies($class)
    {    
        if (class_exists($class) === false) {
            return false;
        }
        
        $interfaces = class_implements($class);  
               
        if (is_array($interfaces)) {
            $setterInjections = array();
            foreach ($interfaces as $interface) {            
                $definition = $this->container->getDefinition($interface);
                if ($definition === null) {
                    continue;
                }       
                
                $dependencies = $definition->getSetterInjections();
                if (empty($dependencies)) {
                    continue;
                }     
                
                $setterInjections = array_merge($setterInjections, $dependencies);                
            }
            
            if (!empty($setterInjections)) {
                $this->container->getDefinition($class)->setSetter($setterInjections); 
            }
        }
    }
    
    public function run() 
    {     
        try {
            $response = null;
            
            $controller = $this->router->resolve();           
            
            if ($controller !== null) {
                $response = $this->invokeController($controller['class'], $controller['method']);
            } else {
                throw new RuntimeException('No matching route.');
            }
            
            if ($response instanceof ResponseInterface) {
                $this->response = $response;
            } else {
                throw new UnexpectedValueException(sprintf(
                    'The method "%s::%s" must return a response object.',
                    $controller['class'],
                    $controller['method']
                ));
            }
        } catch (Exception $e) {
            return $this->handleException($e);
        }		
    }
    
    public function handleException(Exception $e) 
    {
        $this->response->body(highlight_string($e));
    }
}