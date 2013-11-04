<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Form\Control;

use Vision\Form\Decorator;

/**
 * Text
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Text extends AbstractControl
{
    /** @type array $attributes */
    protected $attributes = array('type' => 'text');

    /**
     * Constructor
     *
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->setTag('input')
             ->addDecorator(new Decorator\Label)
             ->addDecorator(new Decorator\Li)
             ->addClass('input-' . $this->getAttribute('type'));
    }
}
