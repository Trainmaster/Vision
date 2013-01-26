<?php
namespace Vision\View;

class JsonView extends AbstractView
{
    public function __toString()
    {
        return json_encode($this->vars);
    }
}