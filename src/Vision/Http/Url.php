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
 * Url
 *
 * @author Frank Liepert
 */
class Url
{   
    /**
     * @api
     * 
     * @param array $parameters 
     * 
     * @return bool|string
     */
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
        
        if (isset($path, $parameters['query'])) {
            $query = $parameters['query'];
            $url .= '?' . http_build_query($query);
        } 
        
        if (isset($query, $parameters['fragment'])) {
            $fragment = $parameters['fragment'];
            $url .= '#' . $fragment;
        }
        
        return $url;
    }
    
    /**
     * @api
     * 
     * @param array $url 
     * @param RequestInterface $request 
     * 
     * @return array
     */
    public function populateFromRequest(array $url, RequestInterface $request)
    {       
        if (!isset($url['scheme'])) {
            if (isset($request->SERVER['HTTPS'])) {
                $scheme = 'https';
            } else {
                $scheme = 'http';
            }
            $url['scheme'] = $scheme;
        }
        
        if (!isset($url['host'])) {
            if (isset($request->SERVER['SERVER_NAME'])) {
                $url['host'] = $request->SERVER['SERVER_NAME'];
            }
        }
        
        $path = $request->getBasePath();
        
        if (!isset($url['path']) && isset($path)) {            
            $url['path'] = $path;
        } else {
            if (strpos($url['path'], '/') !== 0) {
                $url['path'] = '/' . $url['path'];
            }
            $url['path'] = $path . $url['path'];
        }
        
        return $url;    
    }
}