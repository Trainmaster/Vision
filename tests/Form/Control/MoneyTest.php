<?php
namespace VisionTest\Form\Control;

use Vision\Form\Control\Money;

class MoneyTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->control = new Money('money');
    }

    public function testInheritance()
    {
        $control = $this->control;

        $this->assertInstanceOf('Vision\Form\Control\Text', $control);
    }

    public function testDefaultsAfterConstruct()
    {
        $control = $this->control;

        $this->assertSame('EUR', $control->getCurrency());
    }


    public function testDifferentInputCurrency()
    {
        $control = $this->control;

        $control->setValue('1.234.567,89 $');

        $this->assertSame('1.234.567,89 $', $control->getAttribute('value'));
        $this->assertSame(1234567.89, $control->getValue());
        $this->assertSame('USD', $control->getCurrency());
    }

    public function testCurrencySignWithoutEmptySpace()
    {
        $control = $this->control;

        $control->setValue('1.234.567,89$');

        $this->assertSame('1.234.567,89 $', $control->getAttribute('value'));
        $this->assertSame(1234567.89, $control->getValue());
        $this->assertSame('USD', $control->getCurrency());
    }

    public function testLocalizedCurrencySignWithEmptySpace()
    {
        // \Locale::setDefault('en-US');

        // $control = $this->control;

        // $control->setValue('$ 1,234,567.89');

        // $this->assertSame('$1,234,567.89', $control->getAttribute('value'));
        // $this->assertSame(1234567.89, $control->getValue());
        // $this->assertSame('USD', $control->getCurrency());

        // \Locale::setDefault('de-DE');
    }    
    
    public function testLocalizedCurrencySignWithoutEmptySpace()
    {
        \Locale::setDefault('en-US');

        $control = $this->control;

        $control->setValue('$1,234,567.89');

        $this->assertSame('$1,234,567.89', $control->getAttribute('value'));
        $this->assertSame(1234567.89, $control->getValue());
        $this->assertSame('USD', $control->getCurrency());

        \Locale::setDefault('de-DE');
    }

    public function testEuroFormats()
    {
        $control = $this->control;

        $control->setValue('1.234.567,89 EUR');

        // contains non-breaking space
        $this->assertSame('1.234.567,89 €', $control->getAttribute('value'));

        $this->assertSame(1234567.89, $control->getValue());

        $control->setValue('1.234.567,89 €');

        // contains non-breaking space
        $this->assertSame('1.234.567,89 €', $control->getAttribute('value'));

        $this->assertSame(1234567.89, $control->getValue());


        $control->setValue('1.234.567,89');

        // contains non-breaking space
        $this->assertSame('1.234.567,89 €', $control->getAttribute('value'));

        $this->assertSame(1234567.89, $control->getValue());


        $control->setValue('1.234 €');

        // contains non-breaking space
        $this->assertSame('1.234,00 €', $control->getAttribute('value'));

        $this->assertSame(1234.0, $control->getValue());


        $control->setValue('1.234');

        // contains non-breaking space
        $this->assertSame('1.234,00 €', $control->getAttribute('value'));

        $this->assertSame(1234.0, $control->getValue());


        $control->setValue('1.234.567,89');

        // contains non-breaking space
        $this->assertSame('1.234.567,89 €', $control->getAttribute('value'));

        $this->assertSame(1234567.89, $control->getValue());


        $control->setValue('1,23 €');

        // contains non-breaking space
        $this->assertSame('1,23 €', $control->getAttribute('value'));

        $this->assertSame(1.23, $control->getValue());

        $control->setValue('1,23');

        // contains non-breaking space
        $this->assertSame('1,23 €', $control->getAttribute('value'));

        $this->assertSame(1.23, $control->getValue());


        $control->setValue('1.234.567,89');

        // contains non-breaking space
        $this->assertSame('1.234.567,89 €', $control->getAttribute('value'));

        $this->assertSame(1234567.89, $control->getValue());


        $control->setValue('1234567.89');

        // contains non-breaking space
        $this->assertSame('1.234.567,89 €', $control->getAttribute('value'));

        $this->assertSame(1234567.89, $control->getValue());


        $control->setValue(1234567.89);

        // contains non-breaking space
        $this->assertSame('1.234.567,89 €', $control->getAttribute('value'));

        $this->assertSame(1234567.89, $control->getValue());
    }

    public function testUsDollarFormats()
    {
        $control = $this->control;
        $control->setCurrency('USD');

        $control->setValue('1.234.567,89 $');

        // contains non-breaking space
        $this->assertSame('1.234.567,89 $', $control->getAttribute('value'));

        $this->assertSame(1234567.89, $control->getValue());


        $control->setValue('1.234.567,89');

        // contains non-breaking space
        $this->assertSame('1.234.567,89 $', $control->getAttribute('value'));

        $this->assertSame(1234567.89, $control->getValue());


        $control->setValue('1.234 $');

        // contains non-breaking space
        $this->assertSame('1.234,00 $', $control->getAttribute('value'));

        $this->assertSame(1234.0, $control->getValue());


        $control->setValue('1.234');

        // contains non-breaking space
        $this->assertSame('1.234,00 $', $control->getAttribute('value'));

        $this->assertSame(1234.0, $control->getValue());


        $control->setValue('1.234.567,89');

        // contains non-breaking space
        $this->assertSame('1.234.567,89 $', $control->getAttribute('value'));

        $this->assertSame(1234567.89, $control->getValue());


        $control->setValue('1,23 $');

        // contains non-breaking space
        $this->assertSame('1,23 $', $control->getAttribute('value'));

        $this->assertSame(1.23, $control->getValue());

        $control->setValue('1,23');

        // contains non-breaking space
        $this->assertSame('1,23 $', $control->getAttribute('value'));

        $this->assertSame(1.23, $control->getValue());


        $control->setValue('1.234.567,89');

        // contains non-breaking space
        $this->assertSame('1.234.567,89 $', $control->getAttribute('value'));

        $this->assertSame(1234567.89, $control->getValue());


        $control->setValue('1234567.89');

        // contains non-breaking space
        $this->assertSame('1.234.567,89 $', $control->getAttribute('value'));

        $this->assertSame(1234567.89, $control->getValue());


        $control->setValue(1234567.89);

        // contains non-breaking space
        $this->assertSame('1.234.567,89 $', $control->getAttribute('value'));

        $this->assertSame(1234567.89, $control->getValue());
    }
}
