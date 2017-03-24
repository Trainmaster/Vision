<?php
declare(strict_types = 1);

namespace Vision\Validator;

abstract class AbstractMultibyteStringValidator extends AbstractValidator
{
    /**
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
