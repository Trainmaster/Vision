<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Validator;

/**
 * AbstractValidator
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
abstract class AbstractValidator implements ValidatorInterface
{
    /** @type array $errors */
    protected $errors = array();

    /**
     * @param string $error
     *
     * @return $this Provides a fluent interface.
     */
    public function addError($error)
    {
        $this->errors[] = $error;
        return $this;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
