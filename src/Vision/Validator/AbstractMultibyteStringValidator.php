<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Validator;

/**
 * AbstractMultibyteStringValidator
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
abstract class AbstractMultibyteStringValidator extends AbstractValidator
{
    /**
     * @internal
     *
     * @param string $value
     *
     * @return void
     */
    protected function checkEncoding($value)
    {
        $internalEncoding = mb_internal_encoding();
        $externalEncoding = mb_detect_encoding($value);

        if ($internalEncoding !== $externalEncoding && $externalEncoding) {
            mb_internal_encoding($externalEncoding);
        }
    }
}
