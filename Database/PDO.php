<?php
namespace Vision\Database;

class PDO extends \PDO 
{
    /**
    * Workaround for WHERE IN() queries
    *
    * @param array $args
    *
    * @return string
    */
    public function bindArray(array $args) 
    {
        foreach($args as &$arg) {
            $arg = $this->quote($arg);
        }
        $args = implode(',', $args);
        $args = '(' . $args . ')';
        return $args;
    }
}