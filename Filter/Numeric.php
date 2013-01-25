<?php
namespace Vision\Filter;

class Numeric extends PregReplace 
{	
    protected $pattern = '/\P{N}/u';    
}