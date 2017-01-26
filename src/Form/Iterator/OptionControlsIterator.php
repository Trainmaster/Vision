<?php
declare(strict_types=1);

namespace Vision\Form\Iterator;

use Vision\Form\Control\AbstractOptionControl;

use FilterIterator;

class OptionControlsIterator extends FilterIterator
{
    /**
     * @return bool
     */
    public function accept()
    {
        return $this->current() instanceof AbstractOptionControl;
    }
}
