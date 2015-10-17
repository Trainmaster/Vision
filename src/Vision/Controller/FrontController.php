<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Controller;

use Vision\DependencyInjection\ContainerInterface;
use Vision\Http\Response;
use Vision\Http\ResponseInterface;
use Vision\Routing\Router;
use Vision\Routing\AbstractCompiledRoute;

class FrontController
{
    /** @var null|ContainerInterface $container */
    private $container;

    /** @var null|Router $router */
    private $router;

    /** @var null|ExceptionHandlerInterface $exceptionHandler */
    private $exceptionHandler;

    /**
     * @param Router $router
     * @param ContainerInterface $container
     */
    public function __construct(Router $router, ContainerInterface $container)
    {
        $this->router = $router;
        $this->container = $container;
    }

    /**
     * @param ExceptionHandlerInterface $exceptionHandler
     *
     * @return $this Provides a fluent interface.
     */
    public function setExceptionHandler(ExceptionHandlerInterface $exceptionHandler)
    {
        $this->exceptionHandler = $exceptionHandler;
        return $this;
    }

    /**
     * @api
     *
     * @throws \RuntimeException
     *
     * @return ResponseInterface
     */
    public function run()
    {
        try {
            $route = $this->router->resolve();

            if ($route instanceof AbstractCompiledRoute) {
                $class = $route->getClass();
                $method = $route->getMethod();
                return $this->invokeController($class, $method);
            } else {
                throw new \RuntimeException('No matching route.');
            }
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
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
    private function invokeController($class, $method)
    {
        $instance = $this->container->get($class);

        if (!$instance instanceof ControllerInterface) {
            throw new \UnexpectedValueException(sprintf(
                '%s must implement interface %s.',
                $class,
                ControllerInterface::class
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
     * @param \Exception $e
     *
     * @return ResponseInterface
     */
    private function handleException(\Exception $e)
    {
        $response = new Response();
        if (isset($this->exceptionHandler)) {
            $response->body($this->exceptionHandler->handle($e));
        } else {
            $response->body(highlight_string($e));
        }
        return $response;
    }
}
