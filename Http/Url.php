<?php
namespace Vision\Http;

class Url
{
    public function parse($url)
    {
        $url = parse_url($url);
        
        if ($url === false) {
            return false;
        }
        
        return $url;
    }
    
    public function build(array $parameters)
    {        
        $url = '';

        if (isset($parameters['scheme'])) {
            $scheme = $parameters['scheme'];
            $url .= $scheme . '://';
        } else {
            return false;
        }        
        
        if (isset($parameters['host'])) {
            $host = $parameters['host'];
            $url .= $host;
        } else {
            return false;
        }       
        
        if (isset($parameters['path'])) {
            $path = $parameters['path'];
            if (strpos($path, '/') !== 0) {
                $path = '/' . $path;
            }
            $url .= $path;
        }        
        
        if (isset($parameters['query']) && isset($path)) {
            $query = $parameters['query'];
            $url .= '?' . http_build_query($query);
        } 
        
        if (isset($parameters['fragment']) && isset($query)) {
            $fragment = $parameters['fragment'];
            $url .= '#' . $fragment;
        }
        
        return $url;
    }
}