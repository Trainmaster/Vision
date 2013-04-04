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

            if ($route->hasPlaceholder() === false) {

                if ($route->getPath() === $pathInfo) {   
                
                    // <-- repetition
                    $requirements = $route->getRequirements();
                    if (isset($requirements['HTTP_METHOD'])) {
                        if (strcasecmp($this->request->getMethod(), $requirements['HTTP_METHOD']) !== 0) {
                            continue;
                        }
                    }
                    // --> repetition
                    
                    $match = true;
                    break;
                }
            } else {
                $matches = array();
                
                $tokens = array();   
                
                // <-- repetition
                $requirements = $route->getRequirements();                
                if (isset($requirements['HTTP_METHOD'])) {
                    if (strcasecmp($this->request->getMethod(), $requirements['HTTP_METHOD']) !== 0) {
                        continue;
                    }
                }
                // --> repetition
                
                $pattern = $route->getPath();  
                
                preg_match_all('#\{([\w\d_=]+)\}#u', $pattern, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);	
                
                //print '<pre>';                
                // print $pattern;
                
                if (!empty($matches)) {
                    
                    //print_r ($matches);
                    $start = 0;
                    $length = 0;
                    //$regex = '';
                    foreach ($matches as $key => $value) {
                        $regex = '';
                        $length = $value[0][1] - $start;
                        
                        //$regex .= preg_quote(substr($pattern, $start, $length), '#');                        
                        
                        //print $regex;
                        
                        if ($length > 1) {
                            //$regex .= '?';
                        }
                        
                        if (isset($requirements[$value[1][0]])) {
                            // question mark at regex end
                            $regex .= sprintf('(?<%s>%s)', $value[1][0], $requirements[$value[1][0]]);
                        } else {
                            // question mark at regex end
                            $regex .= sprintf('(?<%s>%s)', $value[1][0], $this->defaultParameterPattern);
                        }
                        
                        $start = $value[0][1] + strlen($value[0][0]);
                        $tokens[] = $value[1][0];
                        
                        $replacements[$value[0][0]] = $regex;
                        //print $regex;
                    }                    
                    // $pattern = $regex;
                }		
                
                foreach ($replacements as $k => $v) {
                    $pattern = str_replace($k, $v, $pattern);
                }
                
                //print $pattern;
                //print_r ($replacements);
                //print_r ($tokens);
                
                $pattern = '#^'.$pattern.'$#u';	

                if (preg_match($pattern, $pathInfo, $matches)) {
                    foreach ($tokens as $token) {
                        if (isset($matches[$token])) {
                            $this->request->get[$token] = $matches[$token];
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
                foreach ($defaults as $key => $value) {
                    $this->request->get->$key = $value;;
                }
            }
            return $this->parser->parse($route->getController());
        }
        
        return null;
    }
}