<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Controller;

use Vision\Crypt\Random;
use Vision\Http\RequestInterface;
use Vision\Http\RequestAwareInterface;
use Vision\Http\ResponseInterface;
use Vision\Http\ResponseAwareInterface;
use Vision\Session\Session;
use Vision\Http\Url;

/**
 * AbstractController
 *
 * This class provides a base for all controllers and may be customized.
 *
 * @author Frank Liepert
 */
abstract class AbstractController implements RequestAwareInterface, ResponseAwareInterface,
                                             ControllerInterface
{
    /** @type RequestInterface $request */
    protected $request;

    /** @type ResponseInterface $response */
    protected $response;

    /**
     * This method will be called right after instantiating the controller.
     *
     * @api
     *
     * @return void
     */
    public function preFilter()
    {
        $this->initSessionToken();
    }

    /**
     * This method will be called right after invoking the controller action.
     *
     * @api
     *
     * @return void
     */
    public function postFilter()
    {
    }

    /**
     * @api
     *
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
     * @api
     *
     * @param ResponseInterface $response
     *
     * @return $this Provides a fluent interface.
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * This is a shorthand method for creating a redirect response.
     *
     * @api
     *
     * @param string $url
     *
     * @return bool|ResponseInterface
     */
    public function redirect($url, $statusCode = 302)
    {
        $url = new Url($url);
        $url = $url->populateFromRequest($this->request)->build();

        if ($this->response === null || $url === false) {
            return false;
        }

        $this->response->addHeader('Location', $url)
                       ->setStatusCode($statusCode);

        return $this->response;
    }

    /**
     * This method is for session token generation and may be overridden.
     *
     * @internal
     *
     * @return void
     */
    protected function initSessionToken()
    {
        if (isset($this->session) && empty($this->session['token'])) {
            $random = new Random;
            $token = $random->generateHex(128);
            $this->session['token'] = $token;
        }
    }
}
