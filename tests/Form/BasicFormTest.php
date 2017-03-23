<?php
namespace VisionTest\Form;

use Vision\Form\Form;

require_once 'BasicForm.php';

use PHPUnit\Framework\TestCase;

class BasicFormTest extends TestCase
{
    /** @var Form */
    private $form;

    protected $defaultData = [
        'hidden' => 'hidden-Element',
        'text' => 'text-Element',
        'checkbox' => [
            1 => 'Checkbox1',
            2 => 'Checkbox2',
            3 => 'Checkbox3',
        ],
        'select' => [
            1 => 'Select1',
            2 => 'Select2',
            3 => 'Select3'
        ],
        'radio' => [
            1 => 'Radio1',
            2 => 'Radio2',
            3 => 'Radio3'
        ]
    ];

    public function setUp()
    {
        $this->form = new BasicForm('basic_form');
    }

    public function testGetElement()
    {
        $form = $this->form;

        $this->assertInstanceOf('Vision\Form\Control\Hidden', $form->getElement('hidden'));
        $this->assertInstanceOf('Vision\Form\Control\Text', $form->getElement('text'));

        $this->assertInstanceOf('Vision\Form\Control\Checkbox', $form->getElement('checkbox'));
        $this->assertInstanceOf('Vision\Form\Control\Select', $form->getElement('select'));
        $this->assertInstanceOf('Vision\Form\Control\Radio', $form->getElement('radio'));
    }

    public function testRemoveElement()
    {
        $form = $this->form;

        $hiddenElement = $form->getElement('hidden');

        $this->assertInstanceOf('Vision\Form\Control\Hidden', $hiddenElement);

        $form->removeElement('hidden');

        $this->assertNull($form->getElement('hidden'));
    }

    public function testSetValues()
    {
        $form = $this->form;

        $values = $this->defaultData;

        $form->setValues($values);

        $this->assertSame($values['checkbox'], $form->getElement('checkbox')->getValue());
        $this->assertSame($values['checkbox'], $form->getElement('checkbox')->getValue());
        $this->assertEmpty($form->getElement('checkbox')->getOptions());
        $this->assertEmpty($form->getElement('select')->getOptions());
        $this->assertEmpty($form->getElement('radio')->getOptions());
    }

    public function testSetOptions()
    {
        $form = $this->form;

        $options = $this->defaultData;

        $form->setOptions($options);

        $this->assertNull($form->getElement('checkbox')->getValue());
        $this->assertNull($form->getElement('checkbox')->getValue());
        $this->assertSame($options['checkbox'], $form->getElement('checkbox')->getOptions());
        $this->assertSame($options['select'], $form->getElement('select')->getOptions());
        $this->assertSame($options['radio'], $form->getElement('radio')->getOptions());
    }

    public function testEmptyInputData()
    {
        $form = $this->form;

        $form->setData([]);

        $this->assertFalse($form->isValid());
        $this->assertCount(4, $form->getErrors());
    }

    public function testPartialInvalidInputData()
    {
        $form = $this->form;

        $form->setData([
            'hidden'   => 'hidden',
            'text'     => '',
            'checkbox' => 1,
            'select'   => 1,
            'radio'    => 1
        ]);

        $this->assertFalse($form->isValid());
        $this->assertSame([], $form->getValues());
        $this->assertCount(4, $form->getErrors());
    }

    public function testValidProcessing()
    {
        $form = $this->form;

        $form->setValues($this->defaultData);
        $form->setOptions($this->defaultData);

        $this->assertEmpty($form->getValues());

        $inputData = [
            'text'     => 'Hello World',
            'checkbox' => '1',
            'select'   => '1',
            'radio'    => '1'
        ];

        $form->setData($inputData);

        $this->assertTrue($form->isValid());
        $this->assertCount(0, $form->getErrors());

        $values = [
            'hidden' => null,
            'text'   => 'Hello World',
            'checkbox' => '1',
            'select'   => '1',
            'radio'    => '1'
        ];

        $this->assertSame($values, $form->getValues());
        $this->assertSame($inputData, $form->getData());
    }
}
