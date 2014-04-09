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
 * InArray
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class InArray extends AbstractValidator
{
    /** @type string VALUE_NOT_FOUND */
    const VALUE_NOT_FOUND = 'Value could not be found.';

    /** @type array $haystack */
    protected $haystack = array();

    /** @type bool $strict */
    protected $strict = false;

    /**
     * @param array $options
     */
    public function __construct(array $haystack, $strict = false)
    {
        $this->haystack = $haystack;
        $this->strict = (bool) $strict;
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
        if ($value === null) {
            return true;
        }

        if (is_array($value)) {
            $result = array_diff($value, $this->haystack);
            if (empty($result)) {
                return true;
            }
        }

        if (in_array($value, $this->haystack, $this->strict)) {
            return true;
        }

        $this->addError(self::VALUE_NOT_FOUND);
        $this->addError(array(
            'needle'   => $value,
            'haystack' => $this->haystack,
            'strict'   => $this->strict
        ));

        return false;
    }
}
