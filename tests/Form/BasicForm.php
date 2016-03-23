<?php
namespace VisionTest\Form;

use Vision\Form\Form;
use Vision\Form\Control;

class BasicForm extends Form
{
    public function __construct($name)
    {
        parent::__construct($name);

        // Controls
        $hidden = new Control\Hidden('hidden');

        $text = new Control\Text('text');

        // OptionControls
        $checkbox = new Control\Checkbox('checkbox');

        $select = new Control\Select('select');

        $radio = new Control\Radio('radio');

        $this->addElements([
            $hidden, $text,
            $checkbox, $select, $radio
        ]);
    }
}
