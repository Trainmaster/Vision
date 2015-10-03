<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Validator;

class ValidatorChain
{
    /** @var array $validators */
    protected $validators = array();

    /**
     * @api
     *
     * @param ValidatorInterface $validator
     *
     * @return ValidatorChain Provides a fluent interface.
     */
    public function add(ValidatorInterface $validator)
    {
        $this->validators[] = $validator;
        return $this;
    }

    /**
     * @api
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function isValid($value)
    {
        $isValid = true;

        foreach ($this->validators as $validator) {
            $isValid = $validator->isValid($value);
            if (!$isValid) {
                break;
            }
        }

        return $isValid;
    }
}
