<?php
declare(strict_types=1);

namespace Vision\Controller;

use Vision\Http\RequestInterface;
use Vision\Http\Response;
use Vision\Http\ResponseInterface;
use Vision\Url\Url;

abstract class AbstractController implements ControllerInterface
{
    /** @var RequestInterface $request */
    protected $request;

    /**
     * This method will be called right after instantiating the controller.
     *
     * @return void
     */
    public function preFilter(): void
    {
    }

    /**
     * This method will be called right after invoking the controller action.
     *
     * @return void
     */
    public function postFilter(): void
    {
    }

    /**
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
     * This is a shorthand method for creating a redirect response.
     *
     * @param string $url
     * @param int $statusCode
     *
     * @return bool|ResponseInterface
     */
    public function redirect($url, $statusCode = 302)
    {
        $url = (new Url($url))->populateFromRequest($this->request)->__toString();

        if (empty($url)) {
            return false;
        }

        $response = new Response();
        $response->addHeader('Location', $url)
            ->setStatusCode($statusCode);

        return $response;
    }
}
