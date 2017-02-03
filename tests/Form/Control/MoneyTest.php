<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Money;

use Locale;

class MoneyTest extends \PHPUnit\Framework\TestCase
{
    public function testConstruct()
    {
        Locale::setDefault('de-DE');
        
        $control = new Money('money');
        $this->assertInstanceOf('Vision\Form\Control\Text', $control);
        $this->assertNull($control->getCurrency());
        $this->assertFalse($control->showCurrencySymbol());
    }

    public function testDifferentInputCurrency()
    {
        Locale::setDefault('de-DE');

        $control = new Money('money');
        $control->setValue('1.234.567,89 $');

        $this->assertSame(1234567.89, $control->getValue());
        $this->assertSame('USD', $control->getCurrency());
    }

    public function testCurrencySignWithoutEmptySpace()
    {
        Locale::setDefault('de-DE');
        
        $control = new Money('money');
        $control->setValue('1.234.567,89$');

        $this->assertSame(1234567.89, $control->getValue());
        $this->assertSame('USD', $control->getCurrency());
    }

    public function testLocalizedCurrencySignWithoutEmptySpace()
    {
        Locale::setDefault('en-US');

        $control = new Money('money');
        $control->setValue('$1,234,567.89');

        $this->assertSame(1234567.89, $control->getValue());
        $this->assertSame('USD', $control->getCurrency());
    }

    /**
     * @dataProvider getNumericStringsWithCurrencies
     */
    public function testNumericStringsWIthCurrencies($value, $expectedAttribute, $expectedValue, $expectedCurrency)
    {
        Locale::setDefault('de-DE');

        $control = new Money('money');
        $control->setShowCurrencySymbol(true);
        $control->setValue($value);

        $this->assertSame($expectedAttribute, $control->getAttribute('value'));
        $this->assertSame($expectedValue, $control->getValue());
        $this->assertSame($expectedCurrency, $control->getCurrency());
    }

    public function getNumericStringsWithCurrencies()
    {
        return [
            ['1.234.567,89 EUR', '1.234.567,89 €', 1234567.89, 'EUR'],
            ['1.234.567,89 $', '1.234.567,89 $', 1234567.89, 'USD'],
            ['1.234.567,89 €', '1.234.567,89 €', 1234567.89, 'EUR'],
            ['1.234 EUR', '1.234,00 €', 1234.0, 'EUR'],
            ['1.234 $', '1.234,00 $', 1234.0, 'USD'],
            ['1.234 €', '1.234,00 €', 1234.0, 'EUR'],
            ['1,23 EUR', '1,23 €', 1.23, 'EUR'],
            ['1,23 €', '1,23 €', 1.23, 'EUR'],
            ['1,23 $', '1,23 $', 1.23, 'USD'],
        ];
    }

    /**
     * @dataProvider getNumericStringVariants
     */
    public function testNumericStringsWithoutCurrency($value, $expectedAttribute, $expectedValue)
    {
        Locale::setDefault('de-DE');

        $control = new Money('money');
        $control->setShowCurrencySymbol(true);
        $control->setValue($value);

        $this->assertSame($expectedAttribute, $control->getAttribute('value'));
        $this->assertSame($expectedValue, $control->getValue());
        $this->assertNull($control->getCurrency());
    }

    public function getNumericStringVariants()
    {
        return [
            ['1.234.567,89', '1.234.567,89', 1234567.89],
            ['1.234', '1.234,00', 1234.0],
            ['1,23', '1,23', 1.23],
        ];
    }
}
