<?php
namespace Vision\Controller;

use Vision\Http\RequestInterface;
use Vision\Http\RequestAwareInterface;
use Vision\Http\ResponseInterface;
use Vision\Http\ResponseAwareInterface;

abstract class AbstractController implements RequestAwareInterface, ResponseAwareInterface
{      
    protected $request = null;
    
    protected $response = null;
    
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
        return $this;
    }
    
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
        return $this;
    }
}