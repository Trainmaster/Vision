<?php
namespace Vision\Filter;

class Letter extends PregReplace 
{
    protected $pattern = '/\P{L}/u';
}