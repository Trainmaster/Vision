<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Controller;

use Vision\DependencyInjection\ContainerInterface;
use Vision\Debug\ExceptionHandlerInterface;
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
    protected $container;

    /** @type null|RequestInterface $request */
    protected $request;

    /** @type null|ResponseInterface $response */
    protected $response;

    /** @type null|Router $router */
    protected $router;

    /** @type null|ExceptionHandlerInterface $exceptionHandler */
    protected $exceptionHandler;

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
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
     * @param ExceptionHandlerInterface $handler
     *
     * @return $this Provides a fluent interface.
     */
    public function setExceptionHandler(ExceptionHandlerInterface $exceptionHandler)
    {
        $this->exceptionHandler = $exceptionHandler;
        return $this;
    }

    /**
     * @param string $class
     * @param string $method
     *
     * @throws \RuntimeException
     * @throws \UnexpectedValueException
     *
     * @return ResponseInterface
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
            return $preFilter;
        }

        if (method_exists($instance, $method)) {
            $response = $instance->$method();
        } else {
            throw new \RuntimeException(sprintf(
                'The method "%s::%s" does not exist.',
                $class,
                $method
            ));
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
     *
     * @return void
     */
    public function run()
    {
        try {
            $route = $this->router->resolve();

            if ($route instanceof AbstractCompiledRoute) {
                $class = $route->getClass();
                $method = $route->getMethod();
                $this->response = $this->invokeController($class, $method);
            } else {
                throw new \RuntimeException('No matching route.');
            }
        } catch (\Exception $e) {
            $this->handleException($e);
        }
    }

    /**
     * @internal
     *
     * @param \Exception $e
     *
     * @return void
     */
    protected function handleException(\Exception $e)
    {
        if (isset($this->exceptionHandler)) {
            $this->response->body($this->exceptionHandler->handle($e));
        } else {
            $this->response->body(highlight_string($e));
        }
    }
}
