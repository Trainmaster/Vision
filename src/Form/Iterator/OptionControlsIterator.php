<?php
declare(strict_types=1);

namespace Vision\Form\Iterator;

use Vision\Form\Control\AbstractOptionControl;

use FilterIterator;

/**
 * OptionControlsIterator
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
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
