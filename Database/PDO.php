<?php
namespace Vision\Database;

class PDO extends \PDO 
{   
    /**
    * Workaround for WHERE IN() queries
    *
    * @param mixed $mixed
    *
    * @return array
    */
    public function createQuestionMarks($mixed)
    {
        if (is_array($mixed)) {
            $count = count($mixed) - 1;
            $questionMarks = str_repeat('?,', $count) . '?';   
            return $questionMarks;
        }
        return array();
    }
    
    public function createMultipleValuesList($mixed)
    {
        if (is_array($mixed)) {
            $list = '';
            $count = count($mixed);
            $firstValue = reset($mixed);
            if (is_array($firstValue)) {
                $list = '(' . $this->createQuestionMarks($firstValue) . ')';                             
            } elseif (is_string($firstValue) || is_int($firstValue)) {
                $list = '(?)'; 
            } 
            $list = array_fill(0, $count, $list);  
            return implode(',', $list);
        }
    }
}