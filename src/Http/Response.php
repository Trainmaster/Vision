<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Http;

class Response extends Message implements ResponseInterface
{
    /** @var array $cookies */
    protected $cookies = [];

    /** @var array $rawCookies */
    protected $rawCookies = [];

    /** @var array $headers */
    protected $headers = [];

    /** @var int $statusCode */
    protected $statusCode = 200;

    /** @var string|null $reasonPhrase */
    protected $reasonPhrase;

    /** @var string|null $body */
    protected $body;

    /** @var array $statusCodesAndRecommendedReasonPhrases */
    protected $statusCodesAndRecommendedReasonPhrases = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Time-out',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
        415 => 'Unsupported Media Type',
        416 => 'Requested range not satisfiable',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported'
    ];

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this Provides a fluent interface.
     */
    public function addHeader($name, $value)
    {
        $this->headers[(string) $name] = (string) $value;
        return $this;
    }

    /**
     * @param string $name
     * @param string $value
     * @param int    $expire
     * @param string $path
     * @param string $domain
     * @param bool   $secure
     * @param bool   $httponly
     *
     * @return $this Provides a fluent interface.
     */
    public function addCookie($name, $value = '', $expire = 0, $path = '',
                              $domain = '', $secure = false, $httponly = false)
    {
        $this->cookies[] = func_get_args();
        return $this;
    }

    /**
     * @return array
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * @param string $name
     * @param string $value
     * @param int    $expire
     * @param string $path
     * @param string $domain
     * @param bool   $secure
     * @param bool   $httponly
     *
     * @return $this Provides a fluent interface.
     */
    public function addRawCookie($name, $value = '', $expire = 0, $path = '',
                                 $domain = '', $secure = false, $httponly = false)
    {
        $this->rawCookies[] = func_get_args();
        return $this;
    }

    /**
     * @return array
     */
    public function getRawCookies()
    {
        return $this->rawCookies;
    }

    /**
     * @param mixed $body
     *
     * @return $this Provides a fluent interface.
     */
    public function body($body)
    {
        $this->body .= $body;
        return $this;
    }

    /**
     * @param int $statusCode
     *
     * @return $this Provides a fluent interface.
     */
    public function setStatusCode($statusCode)
    {
        $statusCode = (int) $statusCode;

        if (isset($this->statusCodesAndRecommendedReasonPhrases[$statusCode])) {
            $this->statusCode = $statusCode;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param string $reasonPhrase
     *
     * @return Response Provides a fluent interface.
     */
    public function setReasonPhrase($reasonPhrase)
    {
        $this->reasonPhrase = trim($reasonPhrase);
        return $this;
    }


    /**
     * @return string
     */
    public function getReasonPhrase()
    {
        if ($this->reasonPhrase === null) {
            return $this->statusCodesAndRecommendedReasonPhrases[$this->getStatusCode()];
        }
        return $this->reasonPhrase;
    }

    /**
     * @return void
     */
    public function send()
    {
        $this->sendCookies()
             ->sendStatusLine()
             ->sendHeaders()
             ->sendBody();
    }

    /**
     * @return $this Provides a fluent interface.
     */
    protected function sendCookies()
    {
        foreach ($this->cookies as $cookie) {
            call_user_func_array('setcookie', $cookie);
        }

        foreach ($this->rawCookies as $rawCookie) {
            call_user_func_array('setrawcookie', $rawCookie);
        }

        return $this;
    }

    /**
     * @return $this Provides a fluent interface.
     */
    protected function sendStatusLine()
    {
        $statusLine = sprintf(
            'HTTP/%s %s %s',
            $this->getProtocolVersion(),
            $this->getStatusCode(),
            $this->getReasonPhrase()
        );

        header($statusLine);

        return $this;
    }

    /**
     * @return $this Provides a fluent interface.
     */
    protected function sendHeaders()
    {
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }
        return $this;
    }

    /**
     * @return $this Provides a fluent interface.
     */
    protected function sendBody()
    {
        echo $this->body;
        return $this;
    }
}