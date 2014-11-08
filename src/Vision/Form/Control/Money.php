<?php
/**
 * Vision PHP-Framework
 *
 * @author Frank Liepert <contact@frank-liepert.de>
 * @copyright 2012-2014 Frank Liepert
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

    /** @type bool $showCurrencySymbol */
    protected $showCurrencySymbol = false;

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
     * @param bool $showCurrencySymbol
     *
     * @return $this
     */
    public function setShowCurrencySymbol($showCurrencySymbol)
    {
        $this->showCurrencySymbol = (bool) $showCurrencySymbol;
        return $this;
    }

    /**
     * @return bool
     */
    public function showCurrencySymbol()
    {
        return $this->showCurrencySymbol;
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

        if ($this->showCurrencySymbol) {
            $formattedValue = $fmtCurrency->formatCurrency($this->value, $this->currency);
        } else {
            $formattedValue = number_format(
                $this->value,
                $fmtCurrency->getAttribute(NumberFormatter::MAX_FRACTION_DIGITS),
                $fmtCurrency->getSymbol(NumberFormatter::DECIMAL_SEPARATOR_SYMBOL),
                $fmtCurrency->getSymbol(NumberFormatter::GROUPING_SEPARATOR_SYMBOL)
            );
        }

        parent::setAttribute('value', $formattedValue);

        return $this;
    }
}
