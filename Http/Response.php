<?php
namespace Vision\Http;

/**
 * Response
 *
 * @author Frank Liepert
 */
class Response extends AbstractMessage implements ResponseInterface
{
    protected $headers = array();
    
    protected $statusCode = 200;
    
    protected $reasonPhrase = null;
    
    protected $body = null;
    
    protected $statusCodesAndRecommendedReasonPhrases = array(
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
    );

    public function addHeader($name, $value) 
    {
        $this->headers[(string) $name] = (string) $value;
        return $this;
    }
    
    protected function sendHeaders() 
    {
        foreach ($this->headers as $key => $value) {
            header($key.': '.$value);
        }
        return $this;
    }
    
    public function body($body) 
    {
        $this->body .= (string) $body;
        return $this;
    }
    
    public function sendBody()
    {
        echo $this->body;
    }
    
    public function setStatusCode($statusCode)
    {          
        $statusCode = (int) $statusCode;
        if (isset($this->statusCodesAndRecommendedReasonPhrases[$statusCode])) {         
            $this->statusCode = $statusCode;            
        }
        return $this;
    }
    
    public function getStatusCode()
    {
        return $this->statusCode;
    }
    
    protected function sendStatusLine()
    {
        $statusLine = sprintf(
            'HTTP/%s %s %s', 
            $this->getVersion(), 
            $this->getStatusCode(), 
            $this->getReasonPhrase()
        );
        header($statusLine);
        return $this;
    }
    
    public function setReasonPhrase($reasonPhrase) 
    {
        $this->reasonPhrase = trim($reasonPhrase);
        return $this;
    }
    
    public function getReasonPhrase()
    {
        if ($this->reasonPhrase === null) {
            return $this->statusCodesAndRecommendedReasonPhrases[$this->getStatusCode()];
        }
        return $this->reasonPhrase;
    }
    
    public function send()
    {
        $this->sendStatusLine()
             ->sendHeaders()
             ->sendBody();
    }
}