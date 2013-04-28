<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Controller;

use Vision\DependencyInjection\ContainerInterface;
use Vision\Http\RequestInterface;
use Vision\Http\ResponseInterface;
use Vision\Routing\Router;
use Exception;
use RuntimeException;
use UnexpectedValueException;

/**
 * FrontController
 *
 * @author Frank Liepert
 */
class FrontController 
{
    protected $container = null;
    
    protected $request = null;
    
    protected $response = null;   
    
    protected $router = null;
        
    /**
     *
     *
     *
     *
     *
     */
    public function __construct(RequestInterface $request, ResponseInterface $response, 
                                Router $router, ContainerInterface $container) 
    {
        $this->request = $request; 
        $this->response = $response;
        $this->router = $router;
        $this->container = $container;
    }

    /**
     * 
     * 
     * 
     * @return <type>
     */
    public function getRequest()
    {
        return $this->request;
    }
    
    /**
     * 
     * 
     * 
     * @return <type>
     */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * 
     * 
     * 
     * @return <type>
     */
    public function getRouter()
    {
        return $this->router;
    }
    
    /**
     * 
     * 
     * @param <type> $class 
     * @param <type> $method 
     * 
     * @return <type>
     */
    public function invokeController($class, $method)
    {
        $definition = $this->container->getDefinition($class);
        
        if ($definition === null) {
            return false;
        }

        $this->resolveAbstractDependencies($definition);
        $instance = $this->container->get($class);   
        $instance->preFilter();        
        
        if (method_exists($instance, $method)) {
            return $instance->$method();
        }

        return false;
    }
    
    /**
     * 
     * 
     * @param <type> $definition 
     * 
     * @return <type>
     */
    public function resolveAbstractDependencies($definition)
    {    
        $class = $definition->getClass();
        
        if (class_exists($class) === false) {
            return false;           
        }
        
        $interfaces = class_implements($class);  
        
        $parents = class_parents($class);

        if (is_array($interfaces)) {
            $setterInjections = array();
            foreach ($interfaces as $interface) {            
                $def = $this->container->getDefinition($interface);
                
                if ($def === null) {
                    continue;
                }       
                
                $dependencies = $def->getSetterInjections();
                
                if (empty($dependencies)) {
                    continue;
                }     
                
                $setterInjections = array_merge($setterInjections, $dependencies);                
            }
            
            if (!empty($setterInjections)) {
                $definition->setSetter($setterInjections); 
            }
        }
    }
    
    /**
     * 
     * 
     * 
     * @return <type>
     */
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
    
    /**
     * 
     * 
     * @param <type> $e 
     * 
     * @return <type>
     */
    public function handleException(Exception $e) 
    {
        if ($this->container->isDefined('ExceptionController')) {
            $this->container->getDefinition('ExceptionController')->setter('setException', array($e));
            return $this->invokeController('ExceptionController', 'indexAction');
        }
        $this->response->body(highlight_string($e));
    }
}