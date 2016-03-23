<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2016 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Validator;

class Email extends AbstractValidator
{
    /** @var string INVALID_EMAIL */
    const INVALID_EMAIL = 'The given e-mail address is not valid.';

    /**
     * @param string $email
     *
     * @return bool
     */
    public function isValid($email)
    {
        $this->resetErrors();

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        $this->addError(self::INVALID_EMAIL);

        return false;
    }
}
