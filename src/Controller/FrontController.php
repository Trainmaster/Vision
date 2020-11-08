<?php

declare(strict_types=1);

namespace Vision\Controller;

use Psr\Container\ContainerInterface;
use Vision\Http\RequestInterface;
use Vision\Http\Response;
use Vision\Http\ResponseInterface;
use Vision\Routing\Router;

class FrontController
{
    /** @var ContainerInterface $container */
    private $container;

    /** @var Router $router */
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
    public function setExceptionHandler(ExceptionHandlerInterface $exceptionHandler): self
    {
        $this->exceptionHandler = $exceptionHandler;
        return $this;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws \RuntimeException
     */
    public function run(RequestInterface $request): ResponseInterface
    {
        try {
            $route = $this->router->resolve($request->getMethod(), $request->getPathInfo());

            if ($route === null) {
                throw new \RuntimeException('No matching route.');
            }

            $routeParameters = $route['parameters'] ?? [];
            foreach ($routeParameters as $name => $value) {
                $request->getQueryParams()[(string)$name] = $value;
            }

            return $this->invokeHandler($route['handler'][0] ?? '');
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * @param string $handler
     *
     * @throws \RuntimeException
     * @throws \UnexpectedValueException
     *
     * @return ResponseInterface
     */
    private function invokeHandler(string $handler): ResponseInterface
    {
        $instance = $this->container->get($handler);

        if (!$instance instanceof ControllerInterface) {
            throw new \UnexpectedValueException(sprintf(
                '%s must implement interface %s.',
                $handler,
                ControllerInterface::class
            ));
        }

        $response = null;

        $instance->preFilter();

        $response = $instance();

        if (!($response instanceof ResponseInterface)) {
            throw new \UnexpectedValueException(sprintf(
                'The handler "%s" must return an instance of "%s".',
                $handler,
                ResponseInterface::class
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
    private function handleException(\Exception $e): ResponseInterface
    {
        $response = new Response();
        if (isset($this->exceptionHandler)) {
            $response->body($this->exceptionHandler->handle($e));
        } else {
            $response->body(highlight_string((string) $e));
        }
        return $response;
    }
}
