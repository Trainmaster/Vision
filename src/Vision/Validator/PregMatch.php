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
class PregMatch extends AbstractValidator
{
    /** @type string NO_MATCH_FOUND */
    const NO_MATCH_FOUND = 'No match was found.';

    /** @type null|string $pattern */
    protected $pattern;

    /**
     * @param array $options
     */
    public function __construct(array $options = array())
    {
        if (isset($options['pattern'])) {
            $this->setPattern($options['pattern']);
        }
    }

    /**
     * @api
     *
     * @param string $value
     *
     * @return $this Provides a fluent interface.
     */
    public function setPattern($pattern)
    {
        $this->pattern = (string) $pattern;
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
        $result = preg_match($this->pattern, $value);
        $result = (bool) $result;

        if ($result) {
            return true;
        }

        $this->addError(self::NO_MATCH_FOUND);

        return false;
    }
}
