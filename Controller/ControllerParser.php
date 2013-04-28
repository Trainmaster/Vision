<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Controller;

use InvalidArgumentException;

/**
 * ControllerParser
 *
 * @author Frank Liepert
 */
class ControllerParser implements ControllerParserInterface
{
    /**
     * Parses a string and returns the corresponding class and method names.
     *
     * @param string $controller
     *
     * @throws InvalidArgumentException if the provided argument is malformed.
     *
     * @return array('class' => string, 'method' => string)
     */
    public function parse($controller)
    {
        $continue = false;
        $length = strlen($controller) - 1;
        $first = strpos($controller, ':');
        $last = strrpos($controller, ':');
        $count = substr_count($controller, ':');
        
        if ($first > 0 && $last < $length) {
            $doubleColonCount = substr_count($controller, '::'); 
            if ($doubleColonCount === 1) {
                $count -= 2;
                if ($count > 0) {
                    list($class, $action) = explode('::', $controller, 2);
                    if (strpos($action, ':') === false) {
                        $continue = true;
                    }
                }
            } elseif ($doubleColonCount < 1) {
                $class = $controller;
                $continue = true;         
            }
            
            if ($continue === true) {
                $pos = strripos($class, ':') + 1;
                $rest = substr($class, $pos);
                $rest = 'Controller:' . $rest . 'Controller';
                $class = substr_replace($class, $rest, $pos);
                $class = str_replace(':', '\\', $class);
                $action = (isset($action)) ? $action . 'Action' : 'indexAction';
                return array(
                    'class' => $class, 
                    'method' => $action
                ); 
            }
        }
        
        throw new InvalidArgumentException(sprintf(
            'The string "%s" is malformed. Check the syntax.', 
            $controller
        ));
    }
}