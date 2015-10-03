<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2015 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Validator;

abstract class AbstractValidator implements ValidatorInterface
{
    /** @var array $errors */
    protected $errors = [];

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

    /**
     * @return void
     */
    public function resetErrors()
    {
        $this->errors = [];
    }
}
