<?php
namespace Vision\Routing;

use Vision\Http\Request;

class RouterException extends \Exception {}

class Router 
{
    private $collection = null;

    private $resource = null;

    public $defaultParameterPattern = '[\w.~-]+';

    public function __construct ($loader, $resource) 
    {
        $this->collection = $loader->load($resource, 'Vision\Routing\RouteCollection');
    }
    
    public function resolve(Request $request) 
    {	        
        $match = false;
        
        $path = $request->getPath();
        
        foreach ($this->collection as $route) {
            if ($route->isStatic()) {
                if ($route->getPattern() === $path) {	
                    $match = true;
                    break;
                } else {
                    continue;
                }
            } elseif (strpos($route->getPattern(), '{') !== false)  {
                $matches = array();
                $tokens = array();	
                $pattern = $route->getPattern();							
                $requirements = $route->getRequirements();
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

                if (preg_match($pattern, $path, $matches)) {
                    foreach ($tokens as $token) {
                        if (isset($matches[$token])) {
                            $request->get->add($token, $matches[$token]);
                        }
                    }
                    $match = true;
                    break;
                }
            } else {
                continue;
            }
        }
        
        if ($match === true) {
            if ($route->hasExtras()) {
                foreach ($route->getExtras() as $key => $value) {
                $request->get->add($key, $value);
                }
            }
            return $route;
        }
        
        return null;
    }
}