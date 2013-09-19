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