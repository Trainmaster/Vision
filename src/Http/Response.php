<?php
declare(strict_types = 1);

namespace Vision\Http;

class Response extends Message implements ResponseInterface
{
    /** @var array $cookies */
    private $cookies = [];

    /** @var array $rawCookies */
    private $rawCookies = [];

    /** @var array $headers */
    private $headers = [];

    /** @var int $statusCode */
    private $statusCode = 200;

    /** @var string|null $reasonPhrase */
    private $reasonPhrase;

    /** @var string|null $body */
    private $body;

    /**
     * @see http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
     * @var array $statusCodesAndRecommendedReasonPhrases
     */
    private $statusCodesAndRecommendedReasonPhrases = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
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
        421 => 'Misdirected Request',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version not supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    ];

    public function setStatusCode(int $statusCode): ResponseInterface
    {
        if (isset($this->statusCodesAndRecommendedReasonPhrases[$statusCode])) {
            $this->statusCode = $statusCode;
        }

        return $this;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function addHeader(string $name, string $value): ResponseInterface
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function addCookie(string $name,
                              string $value = '',
                              int $expire = 0,
                              string $path = '',
                              string $domain = '',
                              bool $secure = false,
                              bool $httponly = false): ResponseInterface
    {
        $this->cookies[] = func_get_args();
        return $this;
    }

    public function getCookies(): array
    {
        return $this->cookies;
    }

    public function addRawCookie(string $name,
                                 string $value = '',
                                 int $expire = 0,
                                 string $path = '',
                                 string $domain = '',
                                 bool $secure = false,
                                 bool $httponly = false): ResponseInterface
    {
        $this->rawCookies[] = func_get_args();
        return $this;
    }

    public function getRawCookies(): array
    {
        return $this->rawCookies;
    }

    public function body(string $body): ResponseInterface
    {
        $this->body .= $body;
        return $this;
    }

    public function setReasonPhrase(string $reasonPhrase): ResponseInterface
    {
        $this->reasonPhrase = trim($reasonPhrase);
        return $this;
    }

    public function getReasonPhrase(): string
    {
        if ($this->reasonPhrase === null) {
            return $this->statusCodesAndRecommendedReasonPhrases[$this->getStatusCode()];
        }
        return $this->reasonPhrase;
    }

    public function send()
    {
        $this->sendCookies();
        $this->sendStatusLine();
        $this->sendHeaders();
        $this->sendBody();
    }

    protected function sendCookies()
    {
        foreach ($this->cookies as $cookie) {
            call_user_func_array('setcookie', $cookie);
        }

        foreach ($this->rawCookies as $rawCookie) {
            call_user_func_array('setrawcookie', $rawCookie);
        }
    }

    protected function sendStatusLine()
    {
        $statusLine = sprintf(
            'HTTP/%s %s %s',
            $this->getProtocolVersion(),
            $this->getStatusCode(),
            $this->getReasonPhrase()
        );

        header($statusLine);
    }

    protected function sendHeaders()
    {
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }
    }

    protected function sendBody()
    {
        echo $this->body;
    }
}
