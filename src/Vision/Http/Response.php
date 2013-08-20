<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Http;

/**
 * Response
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Response extends AbstractMessage implements ResponseInterface
{
    /** @type array $headers */
    protected $headers = array();
    
    /** @type int $statusCode */
    protected $statusCode = 200;
    
    /** @type string|null $reasonPhrase */
    protected $reasonPhrase = null;
    
    /** @type string|null $body */
    protected $body = null;
    
    /** @type array $statusCodesAndRecommendedReasonPhrases */
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

    /**
     * @api
     * 
     * @param string $name 
     * @param string $value 
     * 
     * @return Response Provides a fluent interface.
     */
    public function addHeader($name, $value) 
    {
        $this->headers[(string) $name] = (string) $value;
        return $this;
    }   
    
    /**
     * @api
     * 
     * @param mixed $body 
     * 
     * @return Response Provides a fluent interface.
     */
    public function body($body) 
    {
        $this->body .= $body;
        return $this;
    }   
    
    /**
     * @api
     * 
     * @param int $statusCode 
     * 
     * @return Response Provides a fluent interface.
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
     * @api
     * 
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }  
    
    /**
     * @api
     * 
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
     * @api
     * 
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
     * @api
     * 
     * @return void
     */
    public function send()
    {
        $this->sendStatusLine()
             ->sendHeaders()
             ->sendBody();
    }
    
    /**
     * @api
     * 
     * @return Response Provides a fluent interface.
     */
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
    
    /**
     * @api
     * 
     * @return Response Provides a fluent interface.
     */
    protected function sendHeaders() 
    {
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }        
        return $this;
    }
    
    /**
     * @api
     * 
     * @return Response Provides a fluent interface.
     */
    protected function sendBody()
    {
        echo $this->body;
        return $this;
    }
}