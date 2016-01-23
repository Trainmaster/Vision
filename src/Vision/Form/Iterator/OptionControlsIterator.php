<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
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
