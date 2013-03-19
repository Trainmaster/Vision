<?php
namespace Vision\Routing;

use Vision\Controller\ControllerParserInterface;
use Vision\Http\RequestInterface;

class Router extends Config\AbstractConfig
{
    protected $defaultParameterPattern = '[\w.~-]+';
    
    protected $parser = null;
    
    protected $request = null;
    
    public function __construct($parser, $request)
    {        
        $this->setParser($parser);
        $this->setRequest($request);
    }
    
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
        return $this;
    }
    
    public function setParser(ControllerParserInterface $parser)
    {
        $this->parser = $parser;
        return $this;
    }

    public function resolve() 
    {	        
        $match = false;
        
        $pathInfo = $this->request->getPathInfo();
       
        foreach ($this->routes as $route) {
            if ($this->checkRouteForPlaceholder($route) === false) {
                if ($route->getPath() === $pathInfo) {	
                    $match = true;
                    break;
                }
            } else {
                $matches = array();
                $tokens = array();
                $requirements = $route->getRequirements();
                
                if (isset($requirements['HTTP_METHOD'])) {
                    if (strcasecmp($this->request->getMethod(), $requirements['HTTP_METHOD']) !== 0) {
                        break;
                    }
                }
                
                $pattern = $route->getPath();               
                preg_match_all('#\{([\w\d_=]+)\}#u', $pattern, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);	
                if (!empty($matches)) {
                    $start = 0;
                    $length = 0;
                    $regex = '';
                    foreach ($matches as $key => $value) {
                        $length = $value[0][1] - $start;
                        
                        $regex .= preg_quote(substr($pattern, $start, $length), '#');
                        
                        if ($length > 1) {
                            $regex .= '?';
                        }
                        
                        if (isset($requirements[$value[1][0]])) {
                            $regex .= sprintf('(?<%s>%s)?', $value[1][0], $requirements[$value[1][0]]);
                        } else {
                            $regex .= sprintf('(?<%s>%s)?', $value[1][0], $this->defaultParameterPattern);
                        }
                        
                        $start = $value[0][1] + strlen($value[0][0]);
                        $tokens[] = $value[1][0];
                    }                    
                    $pattern = $regex;
                }		

                $pattern = '#^'.$pattern.'$#u';	

                if (preg_match($pattern, $pathInfo, $matches)) {
                    foreach ($tokens as $token) {
                        if (isset($matches[$token])) {
                            $this->request->get->add($token, $matches[$token]);
                        }
                    }
                    $match = true;
                    break;
                }
            }
        }
        
        if ($match === true) {
            $defaults = $route->getDefaults();
            if (!empty($defaults)) {
                foreach ($defaults as $key => &$value) {
                    $this->request->get->add($key, $value);
                }
            }
            return $this->parser->parse($route->getController());
        }
        
        return null;
    }
    
    public function checkRouteForPlaceholder(Route $route)
    {
        if (strpos($route->getPath(), '{') !== false) {
            return true;
        }
        return false;    
    }
}