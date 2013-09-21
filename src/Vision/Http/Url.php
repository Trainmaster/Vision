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
    /** @type array $components */
    protected $components = array();
    
    /**
     * Constructor
     * 
     * @param string $url 
     */
    
    public function __construct($url)
    {
        $components = parse_url($url);
        
        if (!empty($components)) {
            $this->components = $components;
        }
    }
    
    /**
     * @api
     * 
     * @param RequestInterface $request 
     * 
     * @return $this Provides a fluent interface.
     */
    public function populateFromRequest(RequestInterface $request)
    {       
        if (!isset($this->components['scheme'])) {
            if (isset($request->SERVER['HTTPS'])) {
                $scheme = 'https';
            } else {
                $scheme = 'http';
            }
            $this->components['scheme'] = $scheme;
        }
        
        if (!isset($this->components['host'])) {
            if (isset($request->SERVER['SERVER_NAME'])) {
                $this->components['host'] = $request->SERVER['SERVER_NAME'];
            }
        }
        
        $path = $request->getBasePath();
        
        if (!isset($this->components['path']) && isset($path)) {            
            $this->components['path'] = $path;
        } else {
            if (strpos($this->components['path'], '/') !== 0) {
                $this->components['path'] = '/' . $this->components['path'];
            }
            $this->components['path'] = $path . $this->components['path'];
        }
        
        return $this;    
    }
    
    /**
     * @api
     * 
     * @return bool|string
     */
    public function build()
    {        
        $url = '';

        if (isset($this->components['scheme'])) {
            $scheme = $this->components['scheme'];
            $url .= $scheme . '://';
        } else {
            return false;
        }        
        
        if (isset($this->components['host'])) {
            $host = $this->components['host'];
            $url .= $host;
        } else {
            return false;
        }       
        
        if (isset($this->components['path'])) {
            $path = $this->components['path'];
            if (strpos($path, '/') !== 0) {
                $path = '/' . $path;
            }
            $url .= $path;
        }        
        
        if (isset($path, $this->components['query'])) {
            $query = $this->components['query'];
            $url .= '?' . http_build_query($query);
        } 
        
        if (isset($query, $this->components['fragment'])) {
            $fragment = $this->components['fragment'];
            $url .= '#' . $fragment;
        }
        
        return $url;
    }
}