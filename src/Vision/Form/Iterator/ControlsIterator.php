<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
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
     * @api
     *
     * @return bool
     */
    public function accept()
    {
        return $this->current() instanceof AbstractControl;
    }
}
