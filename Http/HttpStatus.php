<?php
namespace Vision\Http;

class Http
{
    const SC_CONTINUE = 100;
    
    const SWITCHING_PROTOCOLS = 101;
    
    const OK = 200;
    
    const CREATED = 201;

    const ACCEPTED = 202;
    
    const NON_AUTHORITATIVE_INFORMATION = 203;
    
    const NO_CONTENT = 204;
    
    const RESET_CONTENT = 205;
    
    public function __call($name, $params)
    {}
}