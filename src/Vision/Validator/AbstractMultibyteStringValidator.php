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
 * AbstractMultibyteStringValidator
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */ 
abstract class AbstractMultibyteStringValidator extends ValidatorAbstract
{
    /**
     * @api
     * 
     * @return void
     */
    protected function checkEncoding()
    {
        $internalEncoding = mb_internal_encoding();
        $externalEncoding = mb_detect_encoding($this->value);
        
        if ($internalEncoding !== $externalEncoding && $externalEncoding) {
            mb_internal_encoding($externalEncoding);
        }
    }
}