<?php
namespace Vision\Controller;

use InvalidArgumentException;

class ControllerParser
{
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
                    'action' => $action
                ); 
            }
        }
        
        throw new InvalidArgumentException(sprintf(
            'The string "%s" is malformed. Check the syntax.', 
            $controller
        ));
    }
}