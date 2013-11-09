<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Form\Control;

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
             ->addClass('input-' . $this->getAttribute('type'));
    }
}
