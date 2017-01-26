<?php
namespace Vision\Form\Iterator;

use Vision\Form\Control\AbstractControl;

use FilterIterator;

/**
 * ControlsIterator
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
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
