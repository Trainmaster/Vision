<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Form\Control;

use Vision\Validator;

/**
 * Email
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Email extends AbstractInput
{
    /** @var array $attributes */
    protected $attributes = array('type' => 'email');

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);

        $this->addValidator(new Validator\Email);
    }
}
