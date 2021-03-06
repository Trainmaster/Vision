<?php

declare(strict_types=1);

namespace Vision\Routing;

class Route
{
    /** @var string $httpMethod */
    protected $httpMethod;

    /** @var null|string $handler */
    protected $handler;

    /** @var null|string $path */
    protected $path;

    /**
     * @param string $httpMethod
     * @param string $path
     * @param string $handler
     */
    public function __construct($httpMethod, $path, $handler)
    {
        $this->setHttpMethod($httpMethod);
        $this->path = trim($path);
        $this->handler = trim($handler);
    }

    /** @return string */
    public function __toString()
    {
        return md5(serialize($this->httpMethod) . $this->path . $this->handler);
    }

    /**
     * @param string $httpMethod
     */
    private function setHttpMethod($httpMethod)
    {
        static $validHttpMethods = ['DELETE', 'HEAD', 'GET', 'OPTIONS', 'POST', 'PUT'];

        $httpMethod = strtoupper($httpMethod);

        if (!in_array($httpMethod, $validHttpMethods)) {
            throw new \UnexpectedValueException(
                sprintf('Method must be one of: %s', implode(', ', $validHttpMethods))
            );
        }

        $this->httpMethod = $httpMethod;
    }

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * @return string
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
