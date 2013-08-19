<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
namespace Vision\Routing;

use Vision\Controller\ControllerParserInterface;
use Vision\Http\RequestInterface;

/**
 * Router
 *
 * @author Frank Liepert
 */
class Router extends Config\AbstractConfig
{
    /** @type string $defaultParameterPattern */
    protected $defaultParameterPattern = '[\w.~-]+';
    
    /** @type null|ControllerParserInterface $parser */
    protected $parser = null;
    
    /** @type null|RequestInterface $request */
    protected $request = null;
    
    /**
     * @param ControllerParserInterface $parser 
     * @param RequestInterface $request 
     * 
     * @return void
     */
    public function __construct(ControllerParserInterface $parser, RequestInterface $request)
    {        
        $this->parser = $parser;
        $this->request = $request;
    }
    
    /**
     * @api
     * 
     * @param string $pattern 
     * 
     * @return Router Provides a fluent interface.
     */
    public function setDefaultParameterPattern($pattern)
    {
        $this->defaultParameterPattern = $pattern;
        return $this;
    }

    /**
     * @api
     * 
     * @todo Needs further refactoring (route compiling etc.)
     * 
     * @return mixed
     */
    public function resolve() 
    {           
        $matched = false;
        $httpMethod = $this->request->getMethod();
        $pathInfo = $this->request->getPathInfo();        

        foreach ($this->routes as $route) {
            $requirements = $route->getRequirements();
            
            if (isset($requirements['HTTP_METHOD'])) {
                if (strcasecmp($httpMethod, $requirements['HTTP_METHOD']) !== 0) {
                    continue;
                }
            }
            
            if ($route->isStatic()) {
                if ($route->getPath() === $pathInfo) {                       
                    $matched = true;
                    break;
                }
            } else {
                $matches = array();
                $tokens = array();                    
                $pattern = $route->getPath();
                
                preg_match_all('#\{([\w\d_=]+)\}#u', $pattern, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);
                
                if (!empty($matches)) {
                    $start = 0;
                    $length = 0;

                    foreach ($matches as $match) {
                        $regex = '';
                        $length = $match[0][1] - $start;
                        
                        if (isset($requirements[$match[1][0]])) {
                            $regex .= sprintf('(?<%s>%s)', $match[1][0], $requirements[$match[1][0]]);
                        } else {
                            $regex .= sprintf('(?<%s>%s)', $match[1][0], $this->defaultParameterPattern);
                        }
                        
                        $start = $match[0][1] + strlen($match[0][0]);
                        $tokens[] = $match[1][0];
                        
                        $pattern = str_replace($match[0][0], $regex, $pattern);
                    }
                }
                
                $pattern = '#^' . $pattern . '$#u';
                
                if (preg_match($pattern, $pathInfo, $matches)) {
                    foreach ($tokens as $token) {
                        if (isset($matches[$token])) {
                            $this->request->get[$token] = $matches[$token];
                        }
                    }
                    $matched = true;
                    break;
                }
            }
        }
        
        if ($matched) {
            $defaults = $route->getDefaults();
            if (!empty($defaults)) {
                foreach ($defaults as $key => $value) {
                    $this->request->get[$key] = $value;
                }
            }
            return $this->parser->parse($route->getController());
        }
        
        return null;
    }
}