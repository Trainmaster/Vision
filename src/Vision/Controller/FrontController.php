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
use Vision\Routing\AbstractCompiledRoute;

/**
 * FrontController
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class FrontController 
{
    /** @type null|ContainerInterface $container */
    protected $container = null;
    
    /** @type null|RequestInterface $request */
    protected $request = null;
    
    /** @type null|ResponseInterface $response */
    protected $response = null;   
    
    /** @type null|Router $router */
    protected $router = null;
        
    /**
     * @param RequestInterface $request
     * @param ReponseInterface $response
     * @param Router $router
     * @param ContainerInterface $container
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
     * @api
     * 
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }
    
    /**
     * @api
     * 
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * @api
     * 
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }
    
    /**
     * @param string $class 
     * @param string $method 
     *
     * @throws \UnexpectedValueException
     * 
     * @return mixed
     */
    public function invokeController($class, $method)
    {
        $instance = $this->container->get($class);
        
        if (!$instance instanceof ControllerInterface) {
            throw new \UnexpectedValueException(sprintf(
                '%s must implement interface %s.',
                $class,
                __NAMESPACE__ . '\ControllerInterface'
            ));
        }
        
        $response = null;
        
        $preFilter = $instance->preFilter();

        if ($preFilter instanceof ResponseInterface) {
            return $response;
        }
        
        if (method_exists($instance, $method)) {
            $response = $instance->$method();
        }
        
        if (!($response instanceof ResponseInterface)) {
            throw new \UnexpectedValueException(sprintf(
                'The method "%s::%s" must return a response object.',
                $class,
                $method
            ));
        }
        
        $instance->postFilter(); 

        return $response;
    }
    
    /**
     * @api
     * 
     * @throws \RuntimeException
     * @throws \UnexpectedValueException
     *
     * @return <type>
     */
    public function run() 
    {     
        try {
            $response = null;
            
            $route = $this->router->resolve();    
            
            if ($route instanceof AbstractCompiledRoute) {
                $class = $route->getClass();
                $method = $route->getMethod();
                $this->response = $this->invokeController($class, $method);
            } else {
                throw new \RuntimeException('No matching route.');
            }           
        } catch (\Exception $e) {
            return $this->handleException($e);
        }       
    }
    
    /**
     * @internal
     * 
     * @param \Exception $e 
     * 
     * @return mixed
     */
    protected function handleException(\Exception $e) 
    {
        if ($this->container->isDefined('ExceptionController')) {
            $this->container->getDefinition('ExceptionController')->setter('setException', array($e));
            return $this->invokeController('ExceptionController', 'indexAction');
        }
        $this->response->body(highlight_string($e));
    }
}