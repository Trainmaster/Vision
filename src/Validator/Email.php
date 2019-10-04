<?php
declare(strict_types=1);

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
    public function validate($email): bool
    {
        $this->resetErrors();

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        $this->addError(self::INVALID_EMAIL);

        return false;
    }
}
