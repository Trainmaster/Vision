<?php
namespace Vision\Http;

/**
 * RequestInterface
 *
 * @author Frank Liepert
 */
interface RequestInterface
{
    public function getMethod();
    
    public function getPath();
    
    public function getPathInfo();
}