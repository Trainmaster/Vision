<?php
declare(strict_types=1);

namespace Vision\Form\Iterator;

use Vision\Form\Control\AbstractControl;

use FilterIterator;

class ControlsIterator extends FilterIterator
{
    /**
     * @return bool
     */
    public function accept()
    {
        return $this->current() instanceof AbstractControl;
    }
}
