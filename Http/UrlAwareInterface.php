<?php
namespace Vision\Http;

/**
 * UrlAwareInterface
 *
 * @author Frank Liepert
 */
interface UrlAwareInterface
{    
    public function setUrl(Url $url);
}