<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Controller;

use Vision\Http\RequestInterface;
use Vision\Http\Response;
use Vision\Http\ResponseInterface;
use Vision\Http\Url;

abstract class AbstractController implements ControllerInterface
{
    /** @var RequestInterface $request */
    protected $request;

    /**
     * This method will be called right after instantiating the controller.
     *
     * @return void
     */
    public function preFilter()
    {
    }

    /**
     * This method will be called right after invoking the controller action.
     *
     * @return void
     */
    public function postFilter()
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
        $url = new Url($url);
        $url = $url->populateFromRequest($this->request)->build();

        if ($url === false) {
            return false;
        }

        $response = new Response();
        $response->addHeader('Location', $url)
            ->setStatusCode($statusCode);

        return $response;
    }
}
