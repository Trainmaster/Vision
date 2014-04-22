<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2013 Frank Liepert
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
namespace Vision\Form\Control;

use NumberFormatter;

/**
 * Money
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 */
class Money extends Text
{
    /** @type string $currency */
    protected $currency = 'EUR';

    /**
     * @api
     *
     * @param string $currency
     *
     * @return $this Provides a fluent interface.
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @api
     *
     * @param mixed $value
     *
     * @return $this Provides a fluent interface.
     */
    public function setValue($value)
    {
        $fmtCurrency = new NumberFormatter(null, NumberFormatter::CURRENCY);

        if (!is_float($value)) {

            $parsedValue = $fmtCurrency->parseCurrency($value, $this->currency);

            if (!$parsedValue) {
                // convert non-breaking space to space
                $fmtCurrency->setPattern(str_replace(' ', ' ', $fmtCurrency->getPattern()));
                $parsedValue = $fmtCurrency->parseCurrency($value, $this->currency);
            }            
            
            if (!$parsedValue) {
                $oldPattern = $fmtCurrency->getPattern();
                $fmtCurrency->setPattern(str_replace(' ', '', $fmtCurrency->getPattern()));
                $parsedValue = $fmtCurrency->parseCurrency($value, $this->currency);
                $fmtCurrency->setPattern($oldPattern);
            }

            if (!$parsedValue) {
                $fmtDecimal = new NumberFormatter(null, NumberFormatter::DECIMAL);
                $parsedValue = $fmtDecimal->parse($value);
            }

            if (!$parsedValue) {
                $parsedValue = (float) $value;
            }

            $value = $parsedValue;
        }

        $this->value = $value;
        
        // convert space to non-breaking space
        $fmtCurrency->setPattern(str_replace(' ', ' ', $fmtCurrency->getPattern()));

        parent::setAttribute('value', $fmtCurrency->formatCurrency($this->value, $this->currency));

        return $this;
    }
}
